<?php
// app/Http/Controllers/VenueBookingController.php

namespace App\Http\Controllers;

use App\Models\VenueBooking;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VenueBookingController extends Controller
{
    /**
     * 🔑 Single source of truth HEADER
     */
    private array $sheetHeaders = [
        'id' => 'ID',
        'created_at' => 'Dibuat',
        'nama_pemesan' => 'Nama Pemesan',
        'nomer_wa' => 'Nomor WhatsApp',
        'email' => 'Email',
        'venue' => 'Venue',
        'jenis_acara' => 'Jenis Acara',
        'tanggal_acara' => 'Tanggal Acara',
        'hari_acara' => 'Hari Acara',
        'tahun_acara' => 'Tahun Acara',
        'jam_acara' => 'Jam Acara',
        'durasi_type' => 'Tipe Durasi',
        'jam_mulai' => 'Jam Mulai',
        'jam_selesai' => 'Jam Selesai',
        'tanggal_mulai' => 'Tanggal Mulai',
        'tanggal_selesai' => 'Tanggal Selesai',
        'durasi_jam' => 'Durasi Jam',
        'durasi_hari' => 'Durasi Hari',
        'durasi_minggu' => 'Durasi Minggu',
        'durasi_bulan' => 'Durasi Bulan',
        'perkiraan_peserta' => 'Perkiraan Peserta',
        'status' => 'Status',
    ];

    /**
     * =====================================================
     * SECTION 1: PUBLIC FORM METHODS
     * =====================================================
     */

    /**
     * Menampilkan form booking venue untuk customer
     */
    public function index(Request $request)
    {
        return view('venue.index', [
            'formData' => Session::get('booking_data', []),
            'currentStep' => Session::get('current_step', 1),
        ]);
    }

    /**
     * Menyimpan booking baru dari form customer
     */
    public function submitBooking(
        Request $request,
        GoogleSheetsService $sheets
    ) {
        $validated = $request->validate([
            'nama_pemesan' => 'required|min:3|max:100',
            'nomer_wa' => 'required|regex:/^08[0-9]{9,12}$/',
            'email' => 'required|email|max:100',
            'venue' => 'required',
            'jenis_acara' => 'required|min:3|max:100',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'jam_acara' => 'required',
            'durasi_type' => 'required',
            'perkiraan_peserta' => 'required|integer|min:1|max:10000',
        ]);

        // simpan DB
        $booking = VenueBooking::create(array_merge(
            $validated,
            [
                'hari_acara' => $request->hari_acara,
                'tahun_acara' => $request->tahun_acara,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'durasi_jam' => $request->durasi_jam,
                'durasi_hari' => $request->durasi_hari,
                'durasi_minggu' => $request->durasi_minggu,
                'durasi_bulan' => $request->durasi_bulan,
                'status' => 'pending',
            ]
        ));

        // Google Sheets
        $sheets->setHeader(
            array_values($this->sheetHeaders),
            'Venue Bookings!A1'
        );

        $row = [
            'id' => $booking->id,
            'created_at' => $booking->created_at
                ->setTimezone('Asia/Jakarta')
                ->format('Y-m-d H:i:s'),
            'nama_pemesan' => $booking->nama_pemesan,
            'nomer_wa' => $booking->nomer_wa,
            'email' => $booking->email,
            'venue' => $booking->venue,
            'jenis_acara' => $booking->jenis_acara,
            'tanggal_acara' => optional($booking->tanggal_acara)->format('Y-m-d'),
            'hari_acara' => $booking->hari_acara ?? '-',
            'tahun_acara' => $booking->tahun_acara ?? '-',
            'jam_acara' => $booking->jam_acara,
            'durasi_type' => $booking->durasi_type,
            'jam_mulai' => $booking->jam_mulai ?? '-',
            'jam_selesai' => $booking->jam_selesai ?? '-',
            'tanggal_mulai' => optional($booking->tanggal_mulai)->format('Y-m-d') ?? '-',
            'tanggal_selesai' => optional($booking->tanggal_selesai)->format('Y-m-d') ?? '-',
            'durasi_jam' => $booking->durasi_jam ?? '-',
            'durasi_hari' => $booking->durasi_hari ?? '-',
            'durasi_minggu' => $booking->durasi_minggu ?? '-',
            'durasi_bulan' => $booking->durasi_bulan ?? '-',
            'perkiraan_peserta' => $booking->perkiraan_peserta,
            'status' => $booking->status,
        ];

        $orderedRow = [];
        foreach (array_keys($this->sheetHeaders) as $key) {
            $orderedRow[] = $row[$key] ?? '-';
        }

        $sheets->append($orderedRow, 'Venue Bookings!A2');

        return redirect()
            ->route('venue.index')
            ->with('success', 'Booking venue berhasil dikirim.');
    }

    /**
     * =====================================================
     * SECTION 2: ADMIN DASHBOARD METHODS - INI YANG DIPERBAIKI
     * =====================================================
     */

    /**
     * Menampilkan halaman data booking venue untuk admin
     * URL: /venue/data
     * View: resources/views/venue/dashboard.blade.php
     */
    public function adminData()
    {
        // ✅ PERBAIKAN: Arahkan ke view venue.dashboard
        return view('venue.dashboard');
    }

    /**
     * Get statistics for venue dashboard
     */
    public function getStats()
    {
        $today = now()->toDateString();
        
        $stats = [
            'total' => VenueBooking::count(),
            'pending' => VenueBooking::where('status', 'pending')->count(),
            'confirmed' => VenueBooking::where('status', 'confirmed')->count(),
            'cancelled' => VenueBooking::where('status', 'cancelled')->count(),
            'today' => VenueBooking::whereDate('tanggal_acara', $today)->count(),
            'total_participants' => VenueBooking::sum('perkiraan_peserta'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get venue distribution
     */
    public function getVenueDistribution()
    {
        $venues = VenueBooking::select('venue', DB::raw('count(*) as total'))
            ->groupBy('venue')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $venues
        ]);
    }

    /**
     * Get bookings data with pagination for admin table
     */
    public function getBookings(Request $request)
    {
        $query = VenueBooking::query();

        // Apply filters
        if (!empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_pemesan', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nomer_wa', 'like', '%' . $request->search . '%')
                  ->orWhere('venue', 'like', '%' . $request->search . '%');
            });
        }

        if (!empty($request->status) && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if (!empty($request->venue) && $request->venue !== 'all') {
            $query->where('venue', $request->venue);
        }

        if (!empty($request->start_date)) {
            $query->whereDate('tanggal_acara', '>=', $request->start_date);
        }

        if (!empty($request->end_date)) {
            $query->whereDate('tanggal_acara', '<=', $request->end_date);
        }

        // Default order
        $query->orderBy('tanggal_acara', 'desc')
              ->orderBy('jam_acara', 'desc')
              ->orderBy('created_at', 'desc');

        // Pagination
        $perPage = $request->per_page ?? 10;
        $bookings = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $bookings->items(),
            'current_page' => $bookings->currentPage(),
            'last_page' => $bookings->lastPage(),
            'total' => $bookings->total(),
            'per_page' => $bookings->perPage()
        ]);
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        try {
            $booking = VenueBooking::findOrFail($id);
            $booking->status = $request->status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Status booking berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status'
            ], 500);
        }
    }

    /**
     * Delete booking
     */
    public function destroy($id)
    {
        try {
            $booking = VenueBooking::findOrFail($id);
            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus booking'
            ], 500);
        }
    }

    /**
     * Export bookings to Excel (simulasi)
     */
    public function export(Request $request)
    {
        try {
            $query = VenueBooking::query();

            if (!empty($request->search)) {
                $query->where('nama_pemesan', 'like', '%' . $request->search . '%');
            }
            if (!empty($request->status) && $request->status !== 'all') {
                $query->where('status', $request->status);
            }
            if (!empty($request->start_date)) {
                $query->whereDate('tanggal_acara', '>=', $request->start_date);
            }
            if (!empty($request->end_date)) {
                $query->whereDate('tanggal_acara', '<=', $request->end_date);
            }

            $bookings = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Export berhasil',
                'total' => $bookings->count(),
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data'
            ], 500);
        }
    }

    /**
     * Get all venues list for filter dropdown
     */
    public function getVenueList()
    {
        $venues = VenueBooking::select('venue')
            ->distinct()
            ->orderBy('venue')
            ->pluck('venue');

        return response()->json([
            'success' => true,
            'data' => $venues
        ]);
    }

    /**
     * Get booking detail by ID
     */
    public function show($id)
    {
        try {
            $booking = VenueBooking::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }
    }
}