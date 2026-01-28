<?php

namespace App\Http\Controllers;

use App\Models\VenueBooking;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function index(Request $request)
    {
        return view('venue.index', [
            'formData' => Session::get('booking_data', []),
            'currentStep' => Session::get('current_step', 1),
        ]);
    }

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

        /**
         * ================================
         * GOOGLE SHEETS (SAMA PERSIS DENGAN SHIFTING)
         * ================================
         */

        // 1️⃣ Pastikan header sinkron
        $sheets->setHeader(
            array_values($this->sheetHeaders),
            'Venue Bookings!A1'
        );

        // 2️⃣ Build row by key
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

        // 3️⃣ Urutkan sesuai header
        $orderedRow = [];
        foreach (array_keys($this->sheetHeaders) as $key) {
            $orderedRow[] = $row[$key] ?? '-';
        }

        // 4️⃣ Append
        $sheets->append($orderedRow, 'Venue Bookings!A2');

        return redirect()
            ->route('venue.index')
            ->with('success', 'Booking venue berhasil dikirim.');
    }
}
