<?php

namespace App\Http\Controllers;

use App\Models\CafeRestoReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CafeRestoController extends Controller
{
    public function index()
    {
        return view('caferesto.index');
    }

    public function store(Request $request)
    {
        Log::info('=== CAFE RESTO RESERVATION REQUEST ===');
        Log::info('Request Data:', $request->all());
        Log::info('IP Address:', [$request->ip()]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'date' => 'required|date',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'table_type' => 'required|string',
            'special_request' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info('Validation passed');
        
        try {
            // Simpan ke database
            $reservation = CafeRestoReservation::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date' => $request->date,
                'time' => $request->time,
                'guests' => $request->guests,
                'table_type' => $request->table_type,
                'special_request' => $request->special_request,
                'status' => 'pending'
            ]);

            Log::info('Reservation saved to database:', [
                'id' => $reservation->id,
                'name' => $reservation->name,
                'phone' => $reservation->phone,
                'date' => $reservation->date
            ]);

            // Simpan ke Google Sheets (jika ada konfigurasi)
            $this->saveToGoogleSheets($reservation);

            // Kirim WhatsApp ke admin
            $this->sendWhatsAppNotification($reservation);

            Log::info('WhatsApp notification prepared');

            return response()->json([
                'success' => true,
                'message' => '✅ Reservasi berhasil dibuat! Anda akan diarahkan ke WhatsApp untuk konfirmasi.',
                'whatsapp_url' => $this->generateWhatsAppUrl($reservation),
                'reservation_id' => 'CR' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT)
            ]);

        } catch (\Exception $e) {
            Log::error('Reservation error: ' . $e->getMessage());
            Log::error('Error trace:', ['trace' => $e->getTraceAsString()]);
            
            return response()->json([
                'success' => false,
                'message' => '❌ Terjadi kesalahan server. Silakan coba lagi atau hubungi kami via WhatsApp.'
            ], 500);
        }
    }

    private function saveToGoogleSheets($reservation)
    {
        try {
            // Konfigurasi Google Sheets
            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
            
            if (!$spreadsheetId) {
                Log::warning('Google Sheets spreadsheet ID not configured');
                return;
            }
            
            $sheetName = 'Reservasi Cafe & Resto';
            
            $data = [
                [
                    date('Y-m-d H:i:s'), // Timestamp
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

            // Jika menggunakan revolution/laravel-google-sheets
            if (class_exists('Revolution\Google\Sheets\Facades\Sheets')) {
                \Revolution\Google\Sheets\Facades\Sheets::spreadsheet($spreadsheetId)
                    ->sheet($sheetName)
                    ->append($data);
                    
                Log::info('Data saved to Google Sheets');
            } else {
                Log::info('Google Sheets data prepared but package not installed:', $data);
            }

        } catch (\Exception $e) {
            Log::error('Google Sheets error: ' . $e->getMessage());
            // Jangan throw error agar proses bisa lanjut
        }
    }

    private function sendWhatsAppNotification($reservation)
    {
        try {
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

            // Simpan ke log
            Log::info('WhatsApp message for admin prepared');
            Log::info('Admin WhatsApp URL: https://wa.me/' . $adminPhone . '?text=' . urlencode($message));

            // Anda bisa mengintegrasikan dengan WhatsApp API di sini
            // Contoh: Twilio, WhatsApp Business API, dll.

        } catch (\Exception $e) {
            Log::error('WhatsApp notification error: ' . $e->getMessage());
        }
    }

    private function generateWhatsAppUrl($reservation)
    {
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

        return "https://wa.me/" . $reservation->phone . "?text=" . urlencode($customerMessage);
    }
}