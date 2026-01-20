<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VenueBookingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data dari session jika ada
        $formData = Session::get('booking_data', []);
        $currentStep = Session::get('current_step', 1);
        
        // Debug: Cek session
        // dd(['formData' => $formData, 'currentStep' => $currentStep]);
        
        return view('venue.index', compact('formData', 'currentStep'));
    }

    public function handleStep(Request $request)
    {
        // HAPUS METHOD INI karena kita pakai client-side navigation
        // Biarkan kosong atau hapus saja
        return redirect()->route('venue.index');
    }

    public function submitBooking(Request $request)
    {
        // Validasi data final (semua field sekaligus)
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
        
        // Validasi tambahan berdasarkan durasi_type
        if ($request->durasi_type === 'jam') {
            $request->validate([
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
            ]);
        } elseif ($request->durasi_type === 'hari') {
            $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            ]);
        } elseif ($request->durasi_type === 'minggu') {
            $request->validate([
                'durasi_minggu' => 'required|integer|min:1|max:4',
            ]);
        } elseif ($request->durasi_type === 'bulan') {
            $request->validate([
                'durasi_bulan' => 'required|integer|min:1|max:12',
            ]);
        }
        
        // Simpan data ke session sebelum redirect
        Session::put('booking_data', array_merge(
            Session::get('booking_data', []),
            $validated,
            $request->only([
                'jam_mulai', 'jam_selesai',
                'tanggal_mulai', 'tanggal_selesai',
                'durasi_minggu', 'durasi_bulan',
                'hari_acara', 'tahun_acara'
            ])
        ));
        
        // Proses penyimpanan ke database (uncomment jika sudah ada model)
        /*
        $booking = VenueBooking::create([
            'nama_pemesan' => $request->nama_pemesan,
            'nomer_wa' => $request->nomer_wa,
            'email' => $request->email,
            'venue' => $request->venue,
            'jenis_acara' => $request->jenis_acara,
            'tanggal_acara' => $request->tanggal_acara,
            'jam_acara' => $request->jam_acara,
            'durasi_type' => $request->durasi_type,
            'durasi_jam' => $request->durasi_jam,
            'durasi_hari' => $request->durasi_hari,
            'durasi_minggu' => $request->durasi_minggu,
            'durasi_bulan' => $request->durasi_bulan,
            'perkiraan_peserta' => $request->perkiraan_peserta,
            'status' => 'pending',
        ]);
        */
        
        // Hapus session setelah sukses
        Session::forget('booking_data');
        Session::forget('current_step');
        
        return redirect()->route('venue.index')
            ->with('success', 'Booking venue berhasil dikirim! Tim kami akan menghubungi Anda dalam 1x24 jam.');
    }
}