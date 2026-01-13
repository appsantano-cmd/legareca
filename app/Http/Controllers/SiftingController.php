<?php

namespace App\Http\Controllers;

use App\Models\Sifting;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiftingController extends Controller
{
    public function index()
    {
        return view('sifting.index');
    }

    public function submit(Request $request, GoogleSheetsService $sheets)
    {
        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required|string|max:255',
            'divisi_jabatan' => 'required|string|max:255',
            'tanggal_shift_asli' => 'required|date',
            'jam_shift_asli' => 'required',
            'tanggal_shift_tujuan' => 'required|date|after_or_equal:tanggal_shift_asli',
            'jam_shift_tujuan' => 'required',
            'alasan' => 'required|string|min:10',
            'sudah_pengganti' => 'required|in:ya,belum',
            'nama_karyawan_pengganti' => 'nullable|required_if:sudah_pengganti,ya|string|max:255',
            'tanggal_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya|date',
            'jam_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ WAJIB: simpan ke database dulu
        $sifting = Sifting::create(array_merge(
            $request->only([
                'nama_karyawan',
                'divisi_jabatan',
                'tanggal_shift_asli',
                'jam_shift_asli',
                'tanggal_shift_tujuan',
                'jam_shift_tujuan',
                'alasan',
                'sudah_pengganti',
                'nama_karyawan_pengganti',
                'tanggal_shift_pengganti',
                'jam_shift_pengganti',
            ]),
            ['status' => 'pending']
        ));

        // ✅ Append ke Google Sheets (sesuai header)
        $sheets->append([
            $sifting->id,                                              // A ID
            now()->format('Y-m-d H:i:s'),                              // B Dibuat
            $sifting->nama_karyawan,                                  // C
            $sifting->divisi_jabatan,                                 // D
            $sifting->tanggal_shift_asli->format('Y-m-d'),            // E
            $sifting->jam_shift_asli,                                 // F
            $sifting->tanggal_shift_tujuan->format('Y-m-d'),          // G
            $sifting->jam_shift_tujuan,                               // H
            $sifting->alasan,                                         // I
            $sifting->sudah_pengganti,                                // J
            $sifting->nama_karyawan_pengganti ?? '-',                 // K
            optional($sifting->tanggal_shift_pengganti)->format('Y-m-d') ?? '-', // L
            $sifting->jam_shift_pengganti ?? '-',                     // M
            $sifting->status,                                         // N
        ], 'Tukar Shift!A2');

        return redirect()
            ->route('sifting.index')
            ->with('success', 'Pengajuan tukar shift berhasil dikirim & tunggu konfirmasi.');
    }
}
