<?php

namespace App\Http\Controllers;

use App\Models\CafeRestoReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Revolution\Google\Sheets\Facades\Sheets;

class CafeRestoController extends Controller
{
    public function index()
    {
        // Return view dari folder caferesto
        return view('caferesto.index');
    }

    public function store(Request $request)
    {
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

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

            // Simpan ke Google Sheets
            $this->saveToGoogleSheets($reservation);

            // Kirim WhatsApp ke admin
            $this->sendWhatsAppNotification($reservation);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat! Anda akan diarahkan ke WhatsApp untuk konfirmasi.',
                'whatsapp_url' => $this->generateWhatsAppUrl($reservation)
            ]);

        } catch (\Exception $e) {
            \Log::error('Reservation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    private function saveToGoogleSheets($reservation)
    {
        try {
            // Konfigurasi Google Sheets
            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
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

            // Append data ke sheet
            Sheets::spreadsheet($spreadsheetId)
                ->sheet($sheetName)
                ->append($data);

        } catch (\Exception $e) {
            \Log::error('Google Sheets error: ' . $e->getMessage());
            // Jangan throw error agar proses bisa lanjut ke WhatsApp
        }
    }

    private function sendWhatsAppNotification($reservation)
    {
        try {
            // Format pesan WhatsApp untuk admin
            $adminPhone = '6281234567890'; // Ganti dengan nomor admin
            $message = "*RESERVASI BARU - LEGARECA CAFE & RESTO*%0A%0A" .
                "*Detail Reservasi:*%0A" .
                "Nama: " . $reservation->name . "%0A" .
                "Telepon: " . $reservation->phone . "%0A" .
                "Email: " . $reservation->email . "%0A" .
                "Tanggal: " . $reservation->date->format('d/m/Y') . "%0A" .
                "Waktu: " . $reservation->time . "%0A" .
                "Jumlah Tamu: " . $reservation->guests . " orang%0A" .
                "Tipe Meja: " . $reservation->table_type . "%0A" .
                "Permintaan Khusus: " . ($reservation->special_request ?: '-') . "%0A%0A" .
                "*ID Reservasi:* CR" . str_pad($reservation->id, 6, '0', STR_PAD_LEFT) . "%0A" .
                "Status: " . strtoupper($reservation->status) . "%0A%0A" .
                "_Silakan konfirmasi reservasi ini segera._";

            // Simpan ke log atau kirim via API
            \Log::info('WhatsApp notification prepared: ' . $message);

            // Anda bisa mengintegrasikan dengan WhatsApp API di sini
            // Contoh: Twilio, WhatsApp Business API, dll.

        } catch (\Exception $e) {
            \Log::error('WhatsApp notification error: ' . $e->getMessage());
        }
    }

    private function generateWhatsAppUrl($reservation)
    {
        // Format pesan untuk pelanggan
        $customerMessage = "*KONFIRMASI RESERVASI - LEGARECA CAFE & RESTO*%0A%0A" .
            "Halo " . $reservation->name . ",%0A%0A" .
            "Terima kasih telah melakukan reservasi di Legareca Cafe & Resto.%0A%0A" .
            "*Detail Reservasi Anda:*%0A" .
            "📅 Tanggal: " . $reservation->date->format('d F Y') . "%0A" .
            "⏰ Waktu: " . $reservation->time . "%0A" .
            "👥 Jumlah Tamu: " . $reservation->guests . " orang%0A" .
            "🪑 Tipe Meja: " . $reservation->table_type . "%0A" .
            "📝 ID Reservasi: CR" . str_pad($reservation->id, 6, '0', STR_PAD_LEFT) . "%0A%0A" .
            "Mohon konfirmasi kehadiran Anda 1 jam sebelum waktu reservasi.%0A" .
            "Untuk perubahan atau pembatalan, silakan hubungi kami.%0A%0A" .
            "_Salam hangat,%0ALegareca Cafe & Resto Team_";

        return "https://wa.me/" . $reservation->phone . "?text=" . urlencode($customerMessage);
    }
}