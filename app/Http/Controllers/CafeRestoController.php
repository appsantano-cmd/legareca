<?php

namespace App\Http\Controllers;

use App\Models\CafeRestoReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CafeRestoController extends Controller
{
    public function index()
    {
        return view('caferesto.index');
    }

    public function store(Request $request)
    {
        // Mulai logging detail
        Log::info('🚀 ========== CAFE RESTO RESERVATION REQUEST START ==========');
        Log::info('📅 Timestamp: ' . now()->toDateTimeString());
        
        // Log semua informasi request
        Log::info('📋 Request Method: ' . $request->method());
        Log::info('🌐 URL: ' . $request->fullUrl());
        Log::info('📍 IP: ' . $request->ip());
        
        // Cek apakah request adalah AJAX
        Log::info('🔄 Is AJAX? ' . ($request->ajax() ? 'Yes' : 'No'));
        Log::info('📦 Is JSON? ' . ($request->isJson() ? 'Yes' : 'No'));
        
        // Log semua input data
        Log::info('📥 Request Data (all):', $request->all());
        Log::info('📥 Request Data (input):', $request->input());
        
        // Log JSON content jika ada
        if ($request->getContent()) {
            Log::info('📄 Raw Content: ' . $request->getContent());
        }
        
        // Cek CSRF token
        $csrfToken = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        Log::info('🔐 CSRF Token from request: ' . ($csrfToken ? substr($csrfToken, 0, 20) . '...' : 'NOT FOUND'));
        Log::info('🔐 Session CSRF Token: ' . substr(session()->token(), 0, 20) . '...');

        // Validasi data
        Log::info('🔍 Starting validation...');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'table_type' => 'required|string',
            'special_request' => 'nullable|string|max:500'
        ], [
            'date.after_or_equal' => 'Tanggal reservasi tidak boleh tanggal kemarin.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.max' => 'Nomor WhatsApp maksimal 20 digit.'
        ]);

        if ($validator->fails()) {
            Log::error('❌ VALIDATION FAILED:', $validator->errors()->toArray());
            Log::error('📝 Failed Data:', $request->all());
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal. Silakan periksa data Anda.'
            ], 422);
        }

        Log::info('✅ Validation passed successfully');
        
        // Mulai transaksi database
        DB::beginTransaction();
        try {
            Log::info('💾 Starting database transaction...');
            
            // Validasi data sebelum save
            $validatedData = $validator->validated();
            Log::info('📋 Validated Data:', $validatedData);
            
            // Simpan ke database
            Log::info('💿 Creating reservation record...');
            
            $reservation = CafeRestoReservation::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'guests' => $validatedData['guests'],
                'table_type' => $validatedData['table_type'],
                'special_request' => $validatedData['special_request'] ?? null,
                'status' => 'pending'
            ]);

            Log::info('🎉 Reservation saved to database!');
            Log::info('📊 Reservation Details:', [
                'id' => $reservation->id,
                'name' => $reservation->name,
                'phone' => $reservation->phone,
                'email' => $reservation->email,
                'date' => $reservation->date,
                'time' => $reservation->time,
                'guests' => $reservation->guests,
                'table_type' => $reservation->table_type,
                'created_at' => $reservation->created_at
            ]);

            // Commit transaksi
            DB::commit();
            Log::info('✅ Database transaction committed');

            // Simpan ke Google Sheets
            Log::info('📊 Attempting to save to Google Sheets...');
            $this->saveToGoogleSheets($reservation);

            // Kirim WhatsApp ke admin
            Log::info('📱 Preparing WhatsApp notifications...');
            $this->sendWhatsAppNotification($reservation);

            // Generate WhatsApp URL untuk customer
            $whatsappUrl = $this->generateWhatsAppUrl($reservation);
            Log::info('🔗 WhatsApp URL generated: ' . $whatsappUrl);

            Log::info('🎊 ========== RESERVATION SUCCESSFULLY PROCESSED ==========');

            return response()->json([
                'success' => true,
                'message' => '✅ Reservasi berhasil dibuat! Anda akan diarahkan ke WhatsApp untuk konfirmasi.',
                'whatsapp_url' => $whatsappUrl,
                'reservation_id' => 'CR' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT),
                'data' => [
                    'name' => $reservation->name,
                    'date' => $reservation->date->format('d/m/Y'),
                    'time' => $reservation->time,
                    'guests' => $reservation->guests
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('💥 RESERVATION ERROR: ' . $e->getMessage());
            Log::error('📝 Error Trace:', ['trace' => $e->getTraceAsString()]);
            Log::error('📁 File: ' . $e->getFile());
            Log::error('📍 Line: ' . $e->getLine());
            
            return response()->json([
                'success' => false,
                'message' => '❌ Terjadi kesalahan server: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }
    }

    private function saveToGoogleSheets($reservation)
    {
        try {
            Log::info('📊 Google Sheets: Starting...');
            
            // Konfigurasi Google Sheets
            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
            
            if (!$spreadsheetId) {
                Log::warning('📊 Google Sheets: Spreadsheet ID not configured in .env');
                Log::info('📊 Google Sheets: Set GOOGLE_SHEETS_SPREADSHEET_ID in .env file');
                return;
            }
            
            Log::info('📊 Google Sheets: Spreadsheet ID found: ' . substr($spreadsheetId, 0, 10) . '...');
            
            $sheetName = 'Reservasi Cafe & Resto';
            
            $data = [
                [
                    now()->format('Y-m-d H:i:s'), // Timestamp
                    $reservation->name,
                    $reservation->phone,
                    $reservation->email,
                    $reservation->date->format('Y-m-d'),
                    $reservation->time,
                    $reservation->guests,
                    $reservation->table_type,
                    $reservation->special_request ?? '-',
                    $reservation->status,
                    $reservation->created_at->format('Y-m-d H:i:s')
                ]
            ];

            Log::info('📊 Google Sheets: Data prepared:', $data[0]);

            // Jika menggunakan revolution/laravel-google-sheets
            if (class_exists('Revolution\Google\Sheets\Facades\Sheets')) {
                Log::info('📊 Google Sheets: Package found, attempting to save...');
                
                \Revolution\Google\Sheets\Facades\Sheets::spreadsheet($spreadsheetId)
                    ->sheet($sheetName)
                    ->append($data);
                    
                Log::info('✅ Google Sheets: Data saved successfully!');
            } else {
                Log::info('⚠️ Google Sheets: Package not installed (revolution/laravel-google-sheets)');
                Log::info('💡 Install with: composer require revolution/laravel-google-sheets');
            }

        } catch (\Exception $e) {
            Log::error('❌ Google Sheets Error: ' . $e->getMessage());
            Log::error('📝 Google Sheets Trace:', ['trace' => $e->getTraceAsString()]);
        }
    }

    private function sendWhatsAppNotification($reservation)
    {
        try {
            Log::info('📱 WhatsApp: Preparing notification for admin...');
            
            // Format pesan WhatsApp untuk admin
            $adminPhone = '6281328897679'; // Ganti dengan nomor admin sebenarnya
            $message = "*📋 RESERVASI BARU - LEGARECA CAFE & RESTO*%0A%0A" .
                "*📝 Detail Reservasi:*%0A" .
                "👤 Nama: " . $reservation->name . "%0A" .
                "📞 Telepon: " . $reservation->phone . "%0A" .
                "📧 Email: " . $reservation->email . "%0A" .
                "📅 Tanggal: " . $reservation->date->format('d/m/Y') . "%0A" .
                "⏰ Waktu: " . $reservation->time . "%0A" .
                "👥 Jumlah Tamu: " . $reservation->guests . " orang%0A" .
                "🪑 Tipe Meja: " . $reservation->table_type . "%0A" .
                "📌 Permintaan Khusus: " . ($reservation->special_request ?: 'Tidak ada') . "%0A%0A" .
                "*🆔 ID Reservasi:* CR" . str_pad($reservation->id, 6, '0', STR_PAD_LEFT) . "%0A" .
                "📊 Status: " . strtoupper($reservation->status) . "%0A" .
                "🕐 Waktu Reservasi: " . $reservation->created_at->format('d/m/Y H:i') . "%0A%0A" .
                "_⚠️ Silakan konfirmasi reservasi ini segera._";

            // URL WhatsApp untuk admin
            $adminWhatsAppUrl = "https://wa.me/" . $adminPhone . "?text=" . $message;
            
            Log::info('📱 WhatsApp: Admin notification prepared');
            Log::info('🔗 WhatsApp Admin URL: ' . $adminWhatsAppUrl);

            // Catat saja untuk sekarang, bisa diintegrasikan dengan API nanti
            Log::info('📱 WhatsApp: Notification ready - integrate with WhatsApp API if needed');

        } catch (\Exception $e) {
            Log::error('❌ WhatsApp Notification Error: ' . $e->getMessage());
        }
    }

    private function generateWhatsAppUrl($reservation)
    {
        Log::info('📱 WhatsApp: Generating URL for customer...');
        
        // Format pesan untuk pelanggan
        $customerMessage = "*✅ KONFIRMASI RESERVASI - LEGARECA CAFE & RESTO*%0A%0A" .
            "Halo " . $reservation->name . ",%0A%0A" .
            "Terima kasih telah melakukan reservasi di Legareca Cafe & Resto.%0A%0A" .
            "*📋 Detail Reservasi Anda:*%0A" .
            "📅 Tanggal: " . $reservation->date->format('d F Y') . "%0A" .
            "⏰ Waktu: " . $reservation->time . " WIB%0A" .
            "👥 Jumlah Tamu: " . $reservation->guests . " orang%0A" .
            "🪑 Tipe Meja: " . $reservation->table_type . "%0A" .
            "🆔 ID Reservasi: CR" . str_pad($reservation->id, 6, '0', STR_PAD_LEFT) . "%0A" .
            "📌 Permintaan Khusus: " . ($reservation->special_request ?: 'Tidak ada') . "%0A%0A" .
            "*📢 Informasi Penting:*%0A" .
            "• Mohon konfirmasi kehadiran Anda 1 jam sebelum waktu reservasi.%0A" .
            "• Meja akan ditahan selama 15 menit dari waktu reservasi.%0A" .
            "• Untuk perubahan atau pembatalan, silakan hubungi kami.%0A" .
            "• Lokasi: Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kasihan, Bantul, Yogyakarta 55181%0A%0A" .
            "_🍽️ Kami tunggu kedatangan Anda!%0ASalam hangat,%0ATim Legareca Cafe & Resto_";

        // URL WhatsApp untuk pelanggan
        $whatsappUrl = "https://wa.me/" . $reservation->phone . "?text=" . $customerMessage;
        
        Log::info('📱 WhatsApp: URL generated for customer');
        Log::info('📱 Customer Phone: ' . $reservation->phone);
        Log::info('🔗 WhatsApp URL (truncated): ' . substr($whatsappUrl, 0, 100) . '...');

        return $whatsappUrl;
    }
}