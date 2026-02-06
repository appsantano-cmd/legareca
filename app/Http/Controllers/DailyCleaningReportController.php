<?php

namespace App\Http\Controllers;

use App\Models\DailyCleaningReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataCleaningExport;

class DailyCleaningReportController extends Controller
{
    // ===== METODE UNTUK FORM INPUT =====

    /**
     * Halaman utama - Form input data baru (Step 1)
     */
    public function index()
    {
        return view('cleaning-report.form-step1');
    }

    /**
     * Halaman form step 1 (alias untuk index)
     */
    public function create()
    {
        return view('cleaning-report.form-step1');
    }

    /**
     * Halaman dashboard data cleaning
     */
    public function dashboard()
    {
        return view('cleaning-report.dashboard');
    }

    // ===== METODE UNTUK DASHBOARD DATA CLEANING (AJAX) =====

    /**
     * Ambil data untuk dashboard (AJAX)
     */
    public function getData(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $statusFilter = $request->input('status', 'all');

            // Query dari tabel daily_cleaning_reports
            $query = DailyCleaningReport::query();

            // Filter pencarian
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                        ->orWhere('departemen', 'LIKE', "%{$search}%")
                        ->orWhere('tanggal', 'LIKE', "%{$search}%");
                });
            }

            // Filter status
            if ($statusFilter !== 'all') {
                $query->where('status', $statusFilter);
            }

            // Hitung total
            $total = $query->count();

            // Ambil data dengan pagination
            $data = $query->orderBy('created_at', 'desc')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();

            // Hitung statistik
            $stats = [
                'total' => DailyCleaningReport::count(),
                'completed' => DailyCleaningReport::where('status', 'completed')->count(),
                'pending' => DailyCleaningReport::where('status', 'pending')->count(),
                'cancelled' => DailyCleaningReport::where('status', 'cancelled')->count(),
                'today' => DailyCleaningReport::whereDate('created_at', today())->count(),
                'this_week' => DailyCleaningReport::whereBetween(
                    'created_at',
                    [now()->startOfWeek(), now()->endOfWeek()]
                )->count(),
                'this_month' => DailyCleaningReport::whereMonth('created_at', now()->month)->count()
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $total,
                'stats' => $stats,
                'current_page' => (int) $page,
                'per_page' => (int) $perPage,
                'last_page' => ceil($total / $perPage)
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get stats untuk dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => DailyCleaningReport::count(),
                'completed' => DailyCleaningReport::where('status', 'completed')->count(),
                'pending' => DailyCleaningReport::where('status', 'pending')->count(),
                'cancelled' => DailyCleaningReport::where('status', 'cancelled')->count(),
                'today' => DailyCleaningReport::whereDate('created_at', today())->count(),
                'this_week' => DailyCleaningReport::whereBetween(
                    'created_at',
                    [now()->startOfWeek(), now()->endOfWeek()]
                )->count(),
                'this_month' => DailyCleaningReport::whereMonth('created_at', now()->month)->count(),

                // Stats per departemen
                'departemen_stats' => DailyCleaningReport::select('departemen', DB::raw('COUNT(*) as count'))
                    ->groupBy('departemen')
                    ->orderBy('count', 'desc')
                    ->get()->toArray(),

                // Stats per hari (7 hari terakhir)
                'last_7_days' => DailyCleaningReport::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                    ->whereDate('created_at', '>=', now()->subDays(7))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()->toArray()
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getStats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik'
            ], 500);
        }
    }

    /**
     * Update data cleaning
     */
    public function updateData(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:daily_cleaning_reports,id',
                'field' => 'required|string|in:nama,departemen,tanggal,status',
                'value' => 'required|string'
            ]);

            $report = DailyCleaningReport::findOrFail($request->id);
            $report->update([$request->field => $request->value]);

            Log::info('Data updated: Report ID ' . $request->id . ', Field: ' . $request->field);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in updateData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses cleaning data
     */
    public function cleanData(Request $request)
    {
        try {
            $action = $request->input('action');
            $cleanedCount = 0;

            switch ($action) {
                case 'clean_duplicates':
                    // Hapus data duplikat berdasarkan nama dan tanggal
                    $duplicates = DB::table('daily_cleaning_reports')
                        ->select('nama', 'tanggal', DB::raw('COUNT(*) as count'))
                        ->groupBy('nama', 'tanggal')
                        ->having('count', '>', 1)
                        ->get();

                    foreach ($duplicates as $dup) {
                        $records = DailyCleaningReport::where('nama', $dup->nama)
                            ->where('tanggal', $dup->tanggal)
                            ->orderBy('id')
                            ->skip(1)
                            ->pluck('id');

                        $cleanedCount += DailyCleaningReport::whereIn('id', $records)->delete();
                    }
                    break;

                case 'clean_null_names':
                    // Update nama yang null
                    $cleanedCount = DailyCleaningReport::whereNull('nama')
                        ->orWhere('nama', '')
                        ->update(['nama' => 'Tidak Diketahui']);
                    break;

                case 'fix_status':
                    // Update status yang tidak valid
                    $cleanedCount = DailyCleaningReport::whereNotIn('status', ['completed', 'pending', 'cancelled'])
                        ->update(['status' => 'pending']);
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => "Data cleaning selesai. {$cleanedCount} data diperbaiki.",
                'cleaned_count' => $cleanedCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error in cleanData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan data cleaning: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus data cleaning
     */
    public function deleteData(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:daily_cleaning_reports,id'
            ]);

            $report = DailyCleaningReport::findOrFail($request->id);

            // Hapus file foto jika ada
            if ($report->foto_path) {
                $filePath = str_replace('storage/', 'public/', $report->foto_path);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $report->delete();

            Log::info('Data deleted: Report ID ' . $request->id);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in deleteData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data ke Excel dengan filter tanggal
     */
    public function exportData(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Generate filename dengan range tanggal jika ada
            $filename = 'Data Cleaning Report';
            
            if ($startDate && $endDate) {
                $filename .= ' - ' . date('d-m-Y', strtotime($startDate)) . ' sampai ' . date('d-m-Y', strtotime($endDate));
            } elseif ($startDate) {
                $filename .= ' - Dari ' . date('d-m-Y', strtotime($startDate));
            } elseif ($endDate) {
                $filename .= ' - Sampai ' . date('d-m-Y', strtotime($endDate));
            } else {
                $filename .= ' - ' . date('d F Y');
            }
            
            $filename .= '.xlsx';

            // Pass filter parameters to export class
            return Excel::download(new DataCleaningExport($startDate, $endDate), $filename);
        } catch (\Exception $e) {
            Log::error('Error in exportData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data: ' . $e->getMessage()
            ]);
        }
    }

    // ===== METODE UNTUK MULTI-STEP FORM =====

    /**
     * Simpan Step 1
     */
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|in:Kitchen,Bar,Marcom,Server,Cleaning Staff',
        ]);

        $request->session()->put('step1_data', $validated);
        return redirect()->route('cleaning-report.step2');
    }

    /**
     * Step 2: Form Tanggal & Foto
     */
    public function showStep2(Request $request)
    {
        $step1Data = $request->session()->get('step1_data');

        if (!$step1Data) {
            return redirect()->route('cleaning-report.create')
                ->with('error', 'Please complete Step 1 first');
        }

        return view('cleaning-report.form-step2', compact('step1Data'));
    }

    /**
     * Simpan Step 2 (Final)
     */
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

            // Handle file upload
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

            // Simpan file ke storage
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
            if ($file->getSize() > 5 * 1024 * 1024) {
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

            // Kirim email notifikasi dengan gambar embedded
            $this->sendEmailNotification($report);

            // Coba simpan ke Google Sheets
            $googleSheetsResult = [
                'success' => false,
                'message' => 'Google Sheets sync skipped for large file upload'
            ];

            // Only try Google Sheets for smaller files
            if ($file->getSize() < 2 * 1024 * 1024) {
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
                ->with('error', 'File terlalu besar. Maksimum ukuran file: 20MB')
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
     * Halaman Selesai
     */
    public function complete($id)
    {
        $report = DailyCleaningReport::findOrFail($id);
        $googleSheetsStatus = session('google_sheets_status', 'unknown');
        $googleSheetsMessage = session('google_sheets_message', '');
        return view('cleaning-report.complete', compact('report', 'googleSheetsStatus', 'googleSheetsMessage'));
    }

    /**
     * Save to Google Sheets
     */
    private function saveToGoogleSheets($report)
    {
        try {
            Log::info('📊 Starting Google Sheets save for report ID: ' . $report->id);
            $credentialsPath = storage_path('app/credentials.json');

            Log::info('🔍 Checking credentials at: ' . $credentialsPath);
            if (!file_exists($credentialsPath)) {
                Log::error('❌ Credentials file not found at: ' . $credentialsPath);
                return [
                    'success' => false,
                    'message' => 'Google Sheets credentials file not found.'
                ];
            }

            // Cek jika file bisa dibaca
            if (!is_readable($credentialsPath)) {
                Log::error('❌ Credentials file is not readable.');
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
            } catch (\Exception $e) {
                Log::error('❌ Cannot access Google Sheets: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Cannot access Google Sheets: ' . $e->getMessage()
                ];
            }

            $sheetName = 'Cleaning';
            Log::info('📝 Using sheet: ' . $sheetName);

            // Prepare row data
            $rowData = [
                $report->id,
                $report->nama,
                $report->tanggal,
                $report->departemen,
                url($report->foto_path),
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
                return [
                    'success' => false,
                    'message' => 'Google Sheets Error: ' . $e->getMessage()
                ];
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
        }
    }

    /**
     * Kirim email notifikasi ke Santano dengan gambar embedded
     */
    private function sendEmailNotification($report)
    {
        try {
            // Email Santano
            $santanoEmail = "appsantano@gmail.com";

            // Subject untuk cleaning report
            $subject = "🧹 Cleaning Report Baru - " . $report->nama . " - Le Gareca Space";

            // Cek apakah file gambar tersedia dan bisa diakses
            $imageEmbedded = false;
            $imagePath = null;

            Log::info('📸 [EMAIL] Raw foto_path from DB', [
                'foto_path' => $report->foto_path
            ]);

            if ($report->foto_path) {

                // Path relatif untuk disk public
                $relativePath = str_replace('storage/', '', $report->foto_path);

                Log::info('📂 [EMAIL] Relative path (public disk)', [
                    'relative_path' => $relativePath
                ]);

                // Cek via Storage disk public
                $existsInDisk = Storage::disk('public')->exists($relativePath);

                Log::info('🧪 [EMAIL] Storage::disk(public)->exists()', [
                    'exists' => $existsInDisk
                ]);

                if ($existsInDisk) {

                    $imagePath = Storage::disk('public')->path($relativePath);

                    Log::info('🧭 [EMAIL] Absolute image path', [
                        'image_path' => $imagePath,
                        'file_exists' => file_exists($imagePath),
                        'file_size' => file_exists($imagePath) ? filesize($imagePath) : null
                    ]);

                    if (file_exists($imagePath)) {
                        $imageEmbedded = true;
                    }
                }
            }

            Log::info('✅ [EMAIL] Final image status', [
                'imageEmbedded' => $imageEmbedded,
                'imagePath' => $imagePath
            ]);

            // Versi pertama: Menggunakan Mail::raw() sederhana (tanpa gambar)
            $plainTextBody = "🧹 CLEANING REPORT — Le Gareca Space 🧹\n\n";
            $plainTextBody .= "Ada input cleaning report baru dari sistem dengan detail berikut:\n\n";
            $plainTextBody .= "👤 Nama: " . $report->nama . "\n";
            $plainTextBody .= "📅 Tanggal: " . $report->tanggal->format('d F Y') . "\n";
            $plainTextBody .= "🏢 Departemen: " . $report->departemen . "\n";
            $plainTextBody .= "⏰ Waktu Input: " . $report->membership_datetime->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s') . "\n";
            $plainTextBody .= "📊 Status: " . ucfirst($report->status) . "\n";
            $plainTextBody .= "📸 Foto: " . ($imageEmbedded ? "Tersedia" : "Tidak tersedia") . "\n\n";
            $plainTextBody .= "Data ini telah tersimpan di database dan Google Sheets.\n\n";
            $plainTextBody .= "Terima kasih.\n\n";
            $plainTextBody .= "-- © Santano 2026 | Sistem Cleaning Report Le Gareca Space --";

            Mail::raw($plainTextBody, function ($message) use ($santanoEmail, $subject, $imageEmbedded, $imagePath) {
                $message->to($santanoEmail)
                    ->subject($subject);

                // Tambahkan gambar sebagai attachment jika tersedia
                if ($imageEmbedded && $imagePath) {
                    $message->attach($imagePath, [
                        'as' => 'cleaning-photo.jpg',
                        'mime' => 'image/jpeg',
                    ]);
                }
            });

            Log::info('✅ Email notification sent to Santano for cleaning report ID: ' . $report->id);

        } catch (\Exception $e) {
            Log::error('❌ Failed to send email notification: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
        }
    }
}