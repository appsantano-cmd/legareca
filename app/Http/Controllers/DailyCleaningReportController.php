<?php

namespace App\Http\Controllers;

use App\Models\DailyCleaningReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DailyCleaningReportController extends Controller
{
    // Step 1: Form Nama & Departemen
    public function create()
    {
        return view('cleaning-report.form-step1');
    }

    // Simpan Step 1
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|in:Kitchen,Bar,Marcom,Server,Cleaning Staff',
        ]);

        $request->session()->put('step1_data', $validated);
        return redirect()->route('cleaning-report.step2');
    }

    // Step 2: Form Tanggal & Foto
    public function showStep2(Request $request)
    {
        $step1Data = $request->session()->get('step1_data');

        if (!$step1Data) {
            return redirect()->route('cleaning-report.create')
                ->with('error', 'Please complete Step 1 first');
        }

        return view('cleaning-report.form-step2', compact('step1Data'));
    }

    // Simpan Step 2 (Final) - DIPERBAIKI untuk handle file besar
    public function storeStep2(Request $request)
    {
        try {
            // Cek session data
            $step1Data = $request->session()->get('step1_data');
            if (!$step1Data) {
                return redirect()->route('cleaning-report.create')
                    ->with('error', 'Session expired. Please start again.');
            }

            // Validasi input dasar
            $request->validate([
                'tanggal' => 'required|date',
            ]);

            // Cek jika ada file
            if (!$request->hasFile('foto')) {
                return back()
                    ->withInput()
                    ->with('error', 'Please select a photo to upload.');
            }

            // Handle file upload dengan streaming untuk menghindari memory issue
            $file = $request->file('foto');
            
            // Log informasi file
            Log::info('File upload attempt', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'size_mb' => round($file->getSize() / 1024 / 1024, 2) . 'MB',
                'type' => $file->getMimeType()
            ]);

            // Cek ukuran file
            $maxSize = config('upload.max_file_size', 20480) * 1024; // Convert KB to bytes
            if ($file->getSize() > $maxSize) {
                return back()
                    ->withInput()
                    ->with('error', 'File size exceeds maximum limit of ' . 
                            config('upload.max_file_size', 20480) . 'KB');
            }

            // Validasi tipe file
            $validMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!in_array($file->getMimeType(), $validMimes)) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid file type. Please upload JPG, PNG, or GIF images only.');
            }

            // Generate nama file
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $storagePath = 'foto-toilet/' . date('Y/m/d');
            $fullStoragePath = $storagePath . '/' . $filename;
            
            // Simpan file ke storage dengan streaming
            // Gunakan putFileAs untuk handle large files
            $path = Storage::disk('public')->putFileAs(
                $storagePath,
                $file,
                $filename
            );

            // Path untuk akses publik
            $publicFotoPath = 'storage/' . $path;
            
            // Kompresi gambar jika diperlukan (gunakan queue untuk file besar)
            if ($file->getSize() > 5 * 1024 * 1024) { // Jika > 5MB
                $this->compressImageInBackground($path);
            }

            // Simpan ke MySQL
            $report = DailyCleaningReport::create([
                'nama' => $step1Data['nama'],
                'tanggal' => $request->tanggal,
                'departemen' => $step1Data['departemen'],
                'foto_path' => $publicFotoPath,
                'membership_datetime' => now(),
                'status' => 'completed',
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType()
            ]);

            Log::info('✅ Data saved to MySQL: ID ' . $report->id);
            
            // Coba simpan ke Google Sheets (non-blocking)
            $googleSheetsResult = [
                'success' => false,
                'message' => 'Google Sheets sync skipped for large file upload'
            ];
            
            // Only try Google Sheets for smaller files to prevent timeout
            if ($file->getSize() < 2 * 1024 * 1024) { // < 2MB
                $googleSheetsResult = $this->simpleSaveToGoogleSheets($report);
            }

            $googleSheetsStatus = $googleSheetsResult['success'] ? 'success' : 'error';
            $googleSheetsMessage = $googleSheetsResult['message'];

            // Hapus session
            $request->session()->forget('step1_data');

            // Redirect dengan success
            return redirect()->route('cleaning-report.complete', $report->id)
                ->with('success', 'Data berhasil disimpan ke Database!')
                ->with('google_sheets_status', $googleSheetsStatus)
                ->with('google_sheets_message', $googleSheetsMessage);

        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            Log::error('PostTooLargeException: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'File terlalu besar. Maksimum ukuran file: ' . 
                        config('upload.max_file_size', 20480) . 'KB')
                ->withInput();
                
        } catch (\Exception $e) {
            Log::error('❌ Error in storeStep2: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to save data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Compress image in background to avoid memory issues
     */
    private function compressImageInBackground($filePath)
    {
        try {
            $fullPath = storage_path('app/public/' . $filePath);
            
            // Check if file exists
            if (!file_exists($fullPath)) {
                Log::warning('File not found for compression: ' . $fullPath);
                return;
            }
            
            // Skip if not an image
            $mime = mime_content_type($fullPath);
            if (!str_starts_with($mime, 'image/')) {
                return;
            }
            
            // Use Intervention Image with memory optimization
            $manager = new ImageManager(new Driver());
            
            // Open image with memory limit
            $image = $manager->read($fullPath);
            
            // Resize if too large
            $maxWidth = 1920;
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }
            
            // Save with compression
            $image->save($fullPath, quality: 80);
            
            Log::info('Image compressed: ' . $filePath);
            
        } catch (\Exception $e) {
            Log::warning('Image compression failed: ' . $e->getMessage());
            // Don't throw error, just log
        }
    }

    /**
     * Simple method untuk save ke Google Sheets
     */
    private function simpleSaveToGoogleSheets($report)
    {
        try {
            $credentialsPath = '/Users/vincentiusadhiel/Library/CloudStorage/OneDrive-UniversitasSanataDharma/Folder Abel/PROJECT/legareca/storage/app/credentials/google-sheets.json';
            
            if (!file_exists($credentialsPath)) {
                return [
                    'success' => false,
                    'message' => 'Credentials file not found'
                ];
            }
            
            $spreadsheetId = '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';
            
            $client = new Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope(Sheets::SPREADSHEETS);
            $client->setAccessType('offline');
            
            $service = new Sheets($client);
            
            $sheetName = 'Cleaning';
            
            $rowData = [
                $report->id,
                $report->nama,
                $report->tanggal,
                $report->departemen,
                $report->foto_path,
                $report->membership_datetime,
                $report->status
            ];
            
            // Get next row
            try {
                $response = $service->spreadsheets_values->get(
                    $spreadsheetId,
                    $sheetName . '!A:A'
                );
                
                $values = $response->getValues();
                $nextRow = empty($values) ? 1 : count($values) + 1;
                
                if ($nextRow === 1) {
                    $headers = ['ID', 'Nama', 'Tanggal', 'Departemen', 'Foto Path', 'Waktu Submit', 'Status'];
                    
                    $headerRange = $sheetName . '!A1:G1';
                    $headerBody = new ValueRange(['values' => [$headers]]);
                    
                    $service->spreadsheets_values->update(
                        $spreadsheetId,
                        $headerRange,
                        $headerBody,
                        ['valueInputOption' => 'RAW']
                    );
                    
                    $nextRow = 2;
                }
            } catch (\Exception $e) {
                $nextRow = 1;
                $headers = ['ID', 'Nama', 'Tanggal', 'Departemen', 'Foto Path', 'Waktu Submit', 'Status'];
                $headerRange = $sheetName . '!A1:G1';
                $headerBody = new ValueRange(['values' => [$headers]]);
                
                $service->spreadsheets_values->update(
                    $spreadsheetId,
                    $headerRange,
                    $headerBody,
                    ['valueInputOption' => 'RAW']
                );
                
                $nextRow = 2;
            }
            
            // Append new row
            $range = $sheetName . '!A' . $nextRow . ':G' . $nextRow;
            $body = new ValueRange(['values' => [$rowData]]);
            
            $result = $service->spreadsheets_values->update(
                $spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );
            
            Log::info('✅ Google Sheets saved. Row: ' . $nextRow);
            
            return [
                'success' => true,
                'message' => 'Data berhasil disimpan ke Google Sheets (Row ' . $nextRow . ')'
            ];
            
        } catch (\Exception $e) {
            Log::error('❌ Google Sheets Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Google Sheets Error: ' . $e->getMessage()
            ];
        }
    }

    // Halaman Selesai
    public function complete($id)
    {
        $report = DailyCleaningReport::findOrFail($id);
        
        $googleSheetsStatus = session('google_sheets_status', 'unknown');
        $googleSheetsMessage = session('google_sheets_message', '');
        
        return view('cleaning-report.complete', compact('report', 'googleSheetsStatus', 'googleSheetsMessage'));
    }

    // Index - Redirect
    public function index()
    {
        return redirect()->route('cleaning-report.create');
    }

    /**
     * Simple test endpoint
     */
    public function simpleTest()
    {
        $credentialsPath = '/Users/vincentiusadhiel/Library/CloudStorage/OneDrive-UniversitasSanataDharma/Folder Abel/PROJECT/legareca/storage/app/credentials/google-sheets.json';
        
        $result = [
            'credentials_path' => $credentialsPath,
            'file_exists' => file_exists($credentialsPath) ? 'YES' : 'NO',
            'is_readable' => is_readable($credentialsPath) ? 'YES' : 'NO',
        ];
        
        if (file_exists($credentialsPath)) {
            $content = file_get_contents($credentialsPath);
            $json = json_decode($content, true);
            
            $result['json_valid'] = $json ? 'YES' : 'NO';
            $result['client_email'] = $json['client_email'] ?? 'NOT FOUND';
            $result['project_id'] = $json['project_id'] ?? 'NOT FOUND';
        }
        
        return response()->json($result);
    }
    
    /**
     * Test Google Sheets connection
     */
    public function testConnection()
    {
        try {
            $credentialsPath = '/Users/vincentiusadhiel/Library/CloudStorage/OneDrive-UniversitasSanataDharma/Folder Abel/PROJECT/legareca/storage/app/credentials/google-sheets.json';
            $spreadsheetId = '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';
            
            if (!file_exists($credentialsPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credentials file not found',
                    'path' => $credentialsPath
                ]);
            }
            
            $client = new Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope(Sheets::SPREADSHEETS);
            $client->setAccessType('offline');
            
            $service = new Sheets($client);
            
            $spreadsheet = $service->spreadsheets->get($spreadsheetId);
            
            $sheets = [];
            foreach ($spreadsheet->sheets as $sheet) {
                $sheets[] = $sheet->properties->title;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Connection successful!',
                'spreadsheet_title' => $spreadsheet->properties->title,
                'sheets' => $sheets,
                'cleaning_sheet_exists' => in_array('Cleaning', $sheets) ? 'YES' : 'NO'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}