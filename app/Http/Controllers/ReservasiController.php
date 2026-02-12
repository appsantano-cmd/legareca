<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman reservasi Legareca Inn
     */
    public function home()
    {
        return view('reservasi.inn.home');
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
            'phone_formatted' => 'nullable|string|max:20', // Format 62xxxxxxxxxx
        ]);

        try {
            DB::beginTransaction();

            // Gunakan nomor yang sudah diformat dari hidden input
            $phoneNumber = $request->input('phone_formatted');

            // Jika tidak ada, format manual
            if (empty($phoneNumber)) {
                $phoneRaw = $validated['phone'];
                // Hapus karakter non-digit
                $phoneRaw = preg_replace('/\D/', '', $phoneRaw);

                // Jika dimulai dengan 0, ganti dengan 62
                if (str_starts_with($phoneRaw, '0')) {
                    $phoneNumber = '62' . substr($phoneRaw, 1);
                }
                // Jika dimulai dengan 62, biarkan
                elseif (str_starts_with($phoneRaw, '62')) {
                    $phoneNumber = $phoneRaw;
                }
                // Jika tidak, tambahkan 62
                else {
                    $phoneNumber = '62' . $phoneRaw;
                }
            }

            // Update validated phone
            $validated['phone'] = $phoneNumber;

            // Hitung durasi dan total harga
            $duration = Reservation::calculateDuration($validated['check_in'], $validated['check_out']);
            $totalPrice = Reservation::calculateTotalPrice($validated['room_price'], $duration, $validated['rooms']);

            // Generate booking code
            $bookingCode = Reservation::generateBookingCode();

            // Simpan ke database
            $reservation = Reservation::create([
                'room_type' => $validated['room_type'],
                'room_price' => $validated['room_price'],
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'guests' => $validated['guests'],
                'rooms' => $validated['rooms'],
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'], // Format 62xxxxxxxxxx
                'email' => $validated['email'],
                'special_request' => $validated['special_request'] ?? null,
                'duration_days' => $duration,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'booking_code' => $bookingCode,
            ]);

            DB::commit();

            // Format pesan untuk WhatsApp
            $whatsappMessage = $this->formatWhatsAppMessage($validated, $reservation);

            // Redirect ke WhatsApp dengan pesan terformat
            $phoneNumber = $validated['phone']; // Sudah format 62xxxxxxxxxx
            $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($whatsappMessage);

            // Redirect ke WhatsApp
            return redirect()->away($whatsappUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses reservasi. Silakan coba lagi.');
        }
    }

    /**
     * Format pesan WhatsApp dari data booking
     */
    private function formatWhatsAppMessage(array $data, ?Reservation $reservation = null): string
    {
        $checkIn = \Carbon\Carbon::parse($data['check_in'])->translatedFormat('d F Y');
        $checkOut = \Carbon\Carbon::parse($data['check_out'])->translatedFormat('d F Y');
        $duration = \Carbon\Carbon::parse($data['check_in'])->diffInDays($data['check_out']);

        $message = "Halo, saya ingin melakukan booking di Legareca Inn.\n\n";

        if ($reservation) {
            $message .= "*Kode Booking: {$reservation->booking_code}*\n\n";
        }

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

    /**
     * Menampilkan daftar semua reservasi
     */
    public function index(Request $request)
    {
        $query = Reservation::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('check_in', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('check_out', '<=', $request->end_date);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $reservations = $query->paginate(10)->withQueryString();

        return view('reservasi.inn.index', compact('reservations'));
    }

    /**
     * Menampilkan detail reservasi
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservasi.inn.show', compact('reservation'));
    }

    /**
     * Menampilkan form edit reservasi
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservasi.inn.edit', compact('reservation'));
    }

    /**
     * Update reservasi
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

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
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        try {
            DB::beginTransaction();

            // Hitung ulang durasi dan total harga
            $duration = Reservation::calculateDuration($validated['check_in'], $validated['check_out']);
            $totalPrice = Reservation::calculateTotalPrice($validated['room_price'], $duration, $validated['rooms']);

            // Update data
            $reservation->update([
                'room_type' => $validated['room_type'],
                'room_price' => $validated['room_price'],
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'guests' => $validated['guests'],
                'rooms' => $validated['rooms'],
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'special_request' => $validated['special_request'] ?? null,
                'duration_days' => $duration,
                'total_price' => $totalPrice,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()->route('reservasi.inn.reservations.show', $reservation->id)
                ->with('success', 'Reservasi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui reservasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Hapus reservasi
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return redirect()->route('reservasi.inn.reservations.index')
                ->with('success', 'Reservasi berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus reservasi. Silakan coba lagi.');
        }
    }

    /**
     * Update status reservasi
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui.',
                'status' => $reservation->status,
                'badge_class' => $reservation->status_badge_class
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status.'
            ], 500);
        }
    }
}