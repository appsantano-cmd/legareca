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
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480', // 20MB max
            ]);

            // Handle file upload dengan streaming untuk menghindari memory issue
            $file = $request->file('foto');

            // Log informasi file
            Log::info('File upload attempt', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'size_mb' => round($file->getSize() / 1024 / 1024, 2) . 'MB',
                'type' => $file->getMimeType()
            ]);

            // Generate nama file
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $storagePath = 'foto-toilet/' . date('Y/m/d');
            $fullStoragePath = $storagePath . '/' . $filename;

            // Simpan file ke storage dengan streaming
            $path = Storage::disk('public')->putFileAs(
                $storagePath,
                $file,
                $filename
            );

            if (!$path) {
                throw new \Exception('Failed to save file to storage.');
            }

            // Path untuk akses publik
            $publicFotoPath = 'storage/' . $path;

            // Kompresi gambar jika diperlukan
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

            // Kirim notifikasi jika ada service notification
            if (class_exists('\App\Services\NotificationService')) {
                $currentUserId = auth()->id();
                \App\Services\NotificationService::send(
                    'cleaning_submitted',
                    $currentUserId,
                    [
                        'staff_name' => $step1Data['nama'],
                        'departemen' => $step1Data['departemen'],
                        'tanggal' => $request->tanggal,
                        'cleaning_id' => $report->id,
                        'user_id' => $currentUserId
                    ]
                );
            }

            // Coba simpan ke Google Sheets (non-blocking)
            $googleSheetsResult = [
                'success' => false,
                'message' => 'Google Sheets sync skipped for large file upload'
            ];

            // Only try Google Sheets for smaller files to prevent timeout
            if ($file->getSize() < 2 * 1024 * 1024) { // < 2MB
                $googleSheetsResult = $this->saveToGoogleSheets($report);
            }

            // Hapus session
            $request->session()->forget('step1_data');

            // Redirect dengan success
            return redirect()->route('cleaning-report.complete', $report->id)
                ->with('success', 'Data berhasil disimpan ke Database!')
                ->with('google_sheets_status', $googleSheetsResult['success'] ? 'success' : 'error')
                ->with('google_sheets_message', $googleSheetsResult['message']);
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            Log::error('PostTooLargeException: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'File terlalu besar. Maksimum ukuran file: ' .
                    config('upload.max_file_size', 20480) . 'KB')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('❌ Error in storeStep2: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Failed to save data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Method untuk save ke Google Sheets dengan path credentials yang benar
     */
    private function saveToGoogleSheets($report)
    {
        try {
            Log::info('📊 Starting Google Sheets save for report ID: ' . $report->id);

            // PATH YANG BENAR: credentials.json di storage/app/
            $credentialsPath = storage_path('app/credentials.json');
            
            Log::info('🔍 Checking credentials at: ' . $credentialsPath);

            if (!file_exists($credentialsPath)) {
                Log::error('❌ Credentials file not found at: ' . $credentialsPath);
                
                // Coba cari di beberapa lokasi umum
                $possiblePaths = [
                    storage_path('app/credentials.json'),
                    base_path('storage/app/credentials.json'),
                    base_path('credentials.json'),
                    app_path('credentials.json'),
                ];
                
                $foundPath = null;
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        $foundPath = $path;
                        Log::info('✅ Found credentials at: ' . $path);
                        break;
                    }
                }
                
                if ($foundPath) {
                    $credentialsPath = $foundPath;
                } else {
                    Log::error('❌ Credentials file not found at any location');
                    Log::info('💡 Please place credentials.json in: ' . storage_path('app/'));
                    
                    return [
                        'success' => false,
                        'message' => 'Google Sheets credentials file not found. Please place credentials.json in storage/app/ folder.'
                    ];
                }
            }

            // Cek jika file bisa dibaca
            if (!is_readable($credentialsPath)) {
                Log::error('❌ Credentials file is not readable. Permissions: ' . substr(sprintf('%o', fileperms($credentialsPath)), -4));
                return [
                    'success' => false,
                    'message' => 'Google Sheets credentials file is not readable.'
                ];
            }

            $spreadsheetId = '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';
            Log::info('📋 Spreadsheet ID: ' . $spreadsheetId);

            // Load credentials untuk validasi
            $credentialsContent = file_get_contents($credentialsPath);
            $credentialsJson = json_decode($credentialsContent, true);

            if (!$credentialsJson) {
                Log::error('❌ Invalid JSON in credentials file');
                return [
                    'success' => false,
                    'message' => 'Invalid credentials JSON format'
                ];
            }

            Log::info('🔑 Service Account: ' . ($credentialsJson['client_email'] ?? 'NOT FOUND'));

            $client = new Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope(Sheets::SPREADSHEETS);
            $client->setAccessType('offline');

            // Tambahkan ini untuk service account authentication
            $client->setSubject($credentialsJson['client_email'] ?? null);

            // Konfigurasi HTTP client
            $httpClientConfig = [
                'timeout' => 60,
                'connect_timeout' => 30,
            ];

            // Hanya di development, disable SSL verification untuk troubleshooting
            if (app()->environment('local')) {
                $httpClientConfig['verify'] = false;
            }

            $client->setHttpClient(new \GuzzleHttp\Client($httpClientConfig));

            $service = new Sheets($client);

            Log::info('🌐 Attempting to access Google Sheets...');

            // Check if spreadsheet exists and is accessible
            try {
                $spreadsheet = $service->spreadsheets->get($spreadsheetId);
                Log::info('✅ Google Sheets accessible. Title: ' . $spreadsheet->properties->title);

                // Cek semua sheet yang ada
                $sheets = [];
                foreach ($spreadsheet->sheets as $sheet) {
                    $sheets[] = $sheet->properties->title;
                }
                Log::info('📄 Available sheets: ' . implode(', ', $sheets));
            } catch (\Exception $e) {
                Log::error('❌ Cannot access Google Sheets: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Cannot access Google Sheets: ' . $e->getMessage()
                ];
            }

            $sheetName = 'Cleaning';
            Log::info('📝 Using sheet: ' . $sheetName);

            // Cek apakah sheet "Cleaning" ada
            $sheetExists = false;
            foreach ($spreadsheet->sheets as $sheet) {
                if ($sheet->properties->title === $sheetName) {
                    $sheetExists = true;
                    break;
                }
            }

            if (!$sheetExists) {
                Log::warning('⚠️ Sheet "Cleaning" not found, trying to use first sheet');
                // Coba gunakan sheet pertama
                if (!empty($spreadsheet->sheets[0])) {
                    $sheetName = $spreadsheet->sheets[0]->properties->title;
                    Log::info('📝 Using first sheet instead: ' . $sheetName);
                } else {
                    Log::error('❌ No sheets available in spreadsheet');
                    return [
                        'success' => false,
                        'message' => 'No sheets available in spreadsheet'
                    ];
                }
            }

            // Prepare row data
            $rowData = [
                $report->id,
                $report->nama,
                $report->tanggal,
                $report->departemen,
                url($report->foto_path), // Convert to full URL
                $report->membership_datetime->format('Y-m-d H:i:s'),
                $report->status
            ];

            Log::info('📊 Row data prepared: ', $rowData);

            // Coba append data ke Google Sheets
            try {
                $range = $sheetName . '!A:G';
                $body = new ValueRange([
                    'values' => [$rowData]
                ]);

                $params = [
                    'valueInputOption' => 'USER_ENTERED',
                    'insertDataOption' => 'INSERT_ROWS'
                ];

                $result = $service->spreadsheets_values->append(
                    $spreadsheetId,
                    $range,
                    $body,
                    $params
                );

                Log::info('✅ Google Sheets append successful');

                return [
                    'success' => true,
                    'message' => 'Data berhasil disimpan ke Google Sheets'
                ];
            } catch (\Exception $e) {
                Log::error('❌ Google Sheets append error: ' . $e->getMessage());
                
                // Coba alternatif: update ke row tertentu
                try {
                    // Cari baris terakhir
                    $response = $service->spreadsheets_values->get($spreadsheetId, $sheetName . '!A:A');
                    $values = $response->getValues();

                    $nextRow = empty($values) ? 1 : count($values) + 1;

                    // Skip header jika ada
                    if ($nextRow === 1 && !empty($values[0]) && strtolower($values[0][0]) === 'id') {
                        $nextRow = 2;
                    }

                    Log::info('📌 Trying update at row: ' . $nextRow);

                    $range = $sheetName . '!A' . $nextRow . ':G' . $nextRow;
                    $body = new ValueRange([
                        'values' => [$rowData]
                    ]);

                    $result = $service->spreadsheets_values->update(
                        $spreadsheetId,
                        $range,
                        $body,
                        ['valueInputOption' => 'USER_ENTERED']
                    );

                    Log::info('✅ Google Sheets update successful');
                    return [
                        'success' => true,
                        'message' => 'Data berhasil disimpan ke Google Sheets (Row ' . $nextRow . ')'
                    ];
                } catch (\Exception $updateError) {
                    Log::error('❌ Google Sheets update error: ' . $updateError->getMessage());
                    return [
                        'success' => false,
                        'message' => 'Google Sheets Error: ' . $updateError->getMessage()
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error('❌ Google Sheets Error: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());

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
     * Simple test endpoint untuk cek credentials
     */
    public function simpleTest()
    {
        $credentialsPath = storage_path('app/credentials.json');
        
        $result = [
            'storage_app_path' => storage_path('app'),
            'credentials_path' => $credentialsPath,
            'file_exists' => file_exists($credentialsPath) ? 'YES' : 'NO',
            'is_readable' => is_readable($credentialsPath) ? 'YES' : 'NO',
            'file_size' => file_exists($credentialsPath) ? filesize($credentialsPath) : 0,
        ];

        if (file_exists($credentialsPath)) {
            $content = file_get_contents($credentialsPath);
            $json = json_decode($content, true);

            $result['json_valid'] = $json ? 'YES' : 'NO';
            $result['client_email'] = $json['client_email'] ?? 'NOT FOUND';
            $result['project_id'] = $json['project_id'] ?? 'NOT FOUND';
            
            if ($json && isset($json['private_key'])) {
                $result['private_key_exists'] = 'YES';
                $result['private_key_length'] = strlen($json['private_key']);
                $result['private_key_first_chars'] = substr($json['private_key'], 0, 50) . '...';
            } else {
                $result['private_key_exists'] = 'NO';
            }
        }

        // Cek beberapa lokasi lain juga
        $otherPaths = [
            'base_path/credentials.json' => base_path('credentials.json'),
            'app_path/credentials.json' => app_path('credentials.json'),
            'base_path/storage/app/credentials.json' => base_path('storage/app/credentials.json'),
        ];
        
        foreach ($otherPaths as $name => $path) {
            $result[$name . '_exists'] = file_exists($path) ? 'YES' : 'NO';
        }

        return response()->json($result);
    }

    /**
     * Test Google Sheets connection
     */
    public function testConnection()
    {
        try {
            $credentialsPath = storage_path('app/credentials.json');
            
            // Coba alternative path
            if (!file_exists($credentialsPath)) {
                $alternativePath = base_path('credentials.json');
                if (file_exists($alternativePath)) {
                    $credentialsPath = $alternativePath;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Credentials file not found',
                        'checked_paths' => [
                            'storage/app/credentials.json' => storage_path('app/credentials.json'),
                            'credentials.json (root)' => base_path('credentials.json'),
                        ]
                    ]);
                }
            }

            $spreadsheetId = '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';

            if (!file_exists($credentialsPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credentials file not found',
                    'path' => $credentialsPath
                ]);
            }

            // Validasi file credentials
            $content = file_get_contents($credentialsPath);
            $json = json_decode($content, true);

            if (!$json) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON in credentials file'
                ]);
            }

            if (!isset($json['client_email']) || !isset($json['private_key'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing required fields in credentials (client_email or private_key)'
                ]);
            }

            $client = new Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope(Sheets::SPREADSHEETS);
            $client->setAccessType('offline');

            // Set timeout lebih lama
            $client->setHttpClient(new \GuzzleHttp\Client([
                'timeout' => 60,
                'connect_timeout' => 30,
            ]));

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
                'cleaning_sheet_exists' => in_array('Cleaning', $sheets) ? 'YES' : 'NO',
                'client_email' => $json['client_email']
            ]);
        } catch (\Exception $e) {
            Log::error('Test connection error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'error_type' => get_class($e)
            ]);
        }
    }

    /**
     * Helper untuk compress image (optional)
     */
    private function compressImageInBackground($filePath)
    {
        try {
            $fullPath = storage_path('app/public/' . $filePath);

            if (!file_exists($fullPath)) {
                Log::warning('File not found for compression: ' . $fullPath);
                return;
            }

            // Skip if not an image
            $mime = mime_content_type($fullPath);
            if (!str_starts_with($mime, 'image/')) {
                return;
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($fullPath);

            // Resize jika terlalu besar
            $maxWidth = 1920;
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            // Save dengan kompresi
            $image->save($fullPath, quality: 80);

            Log::info('Image compressed: ' . $filePath);
        } catch (\Exception $e) {
            Log::warning('Image compression failed: ' . $e->getMessage());
            // Jangan throw error, cukup log saja
        }
    }
}