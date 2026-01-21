<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman reservasi Legareca Inn
     */
    public function innIndex()
    {
        return view('reservasi.inn.index');
    }
    
    /**
     * Memproses form booking Legareca Inn
     */
    public function innSubmit(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'room_type' => 'required|string|max:100',
            'room_price' => 'required|string|max:50',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:10',
            'rooms' => 'required|integer|min:1|max:10',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'special_request' => 'nullable|string|max:1000',
        ]);
        
        // Format pesan untuk WhatsApp
        $whatsappMessage = $this->formatWhatsAppMessage($validated);
        
        // Simpan ke database jika diperlukan
        // $booking = \App\Models\Reservation::create($validated);
        
        // Redirect ke WhatsApp dengan pesan terformat
        $phoneNumber = '6281234567890'; // Ganti dengan nomor WhatsApp resmi
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($whatsappMessage);
        
        // Redirect ke WhatsApp
        return redirect()->away($whatsappUrl);
    }
    
    /**
     * Format pesan WhatsApp dari data booking
     */
    private function formatWhatsAppMessage(array $data): string
    {
        $checkIn = \Carbon\Carbon::parse($data['check_in'])->translatedFormat('d F Y');
        $checkOut = \Carbon\Carbon::parse($data['check_out'])->translatedFormat('d F Y');
        $duration = \Carbon\Carbon::parse($data['check_in'])->diffInDays($data['check_out']);
        
        $message = "Halo, saya ingin melakukan booking di Legareca Inn.\n\n";
        $message .= "*Detail Booking:*\n";
        $message .= "• Tipe Kamar: {$data['room_type']}\n";
        $message .= "• Harga: {$data['room_price']}/malam\n";
        $message .= "• Check-in: {$checkIn}\n";
        $message .= "• Check-out: {$checkOut}\n";
        $message .= "• Durasi: {$duration} malam\n";
        $message .= "• Jumlah Tamu: {$data['guests']} orang\n";
        $message .= "• Jumlah Kamar: {$data['rooms']} kamar\n";
        $message .= "• Nama: {$data['full_name']}\n";
        $message .= "• WhatsApp: {$data['phone']}\n";
        $message .= "• Email: {$data['email']}\n";
        
        if (!empty($data['special_request'])) {
            $message .= "• Permintaan Khusus: {$data['special_request']}\n";
        }
        
        $message .= "\nMohon informasi untuk langkah selanjutnya.\nTerima kasih.";
        
        return $message;
    }
}