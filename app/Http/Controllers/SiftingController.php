<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sifting;
use Illuminate\Support\Facades\Validator;

class SiftingController extends Controller
{
    public function index()
    {
        return view('sifting.index');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required|string|max:255',
            'divisi_jabatan' => 'required|string|max:255',

            'tanggal_shift_asli'   => 'required|date',
            'jam_shift_asli'       => 'required',

            'tanggal_shift_tujuan' => 'required|date|after_or_equal:tanggal_shift_asli',
            'jam_shift_tujuan'     => 'required',

            'alasan' => 'required|string|min:10',

            'sudah_pengganti' => 'required|in:ya,belum',
            'nama_karyawan_pengganti' => 'nullable|required_if:sudah_pengganti,ya|string|max:255',
            'tanggal_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya|date',
            'jam_shift_pengganti'     => 'nullable|required_if:sudah_pengganti,ya',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Sifting::create([
            'nama_karyawan' => $request->nama_karyawan,
            'divisi_jabatan' => $request->divisi_jabatan,

            'tanggal_shift_asli' => $request->tanggal_shift_asli,
            'jam_shift_asli' => $request->jam_shift_asli,
            'tanggal_shift_tujuan' => $request->tanggal_shift_tujuan,
            'jam_shift_tujuan' => $request->jam_shift_tujuan,

            'alasan' => $request->alasan,

            'sudah_pengganti' => $request->sudah_pengganti,
            'nama_karyawan_pengganti' => $request->nama_karyawan_pengganti,
            'tanggal_shift_pengganti' => $request->tanggal_shift_pengganti,
            'jam_shift_pengganti' => $request->jam_shift_pengganti,

            'status' => 'pending',
        ]);

        return redirect()
            ->route('sifting.index')
            ->with('success', 'Pengajuan tukar shift berhasil dikirim.');
    }
}
