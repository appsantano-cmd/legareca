<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sifting;
use Illuminate\Support\Facades\Validator;

class SiftingController extends Controller
{
    /**
     * =========================================================
     * PUBLIC – FORM PENGAJUAN TUKAR SHIFT (MULTI STEP)
     * =========================================================
     */

    public function index()
    {
        return view('sifting.index');
    }

    public function submit(Request $request)
    {
        /**
         * VALIDASI DATA
         */
        $validator = Validator::make($request->all(), [
            // STEP 1
            'nama_karyawan' => 'required|string|max:255',

            // STEP 2
            'divisi_jabatan' => 'required|string|max:255',

            // STEP 3 – SHIFT ASLI
            'tanggal_shift_asli'   => 'required|date',
            'jam_shift_asli'       => 'required',

            // STEP 3 – SHIFT TUJUAN
            'tanggal_shift_tujuan' => 'required|date|after_or_equal:tanggal_shift_asli',
            'jam_shift_tujuan'     => 'required',

            // STEP 4
            'alasan' => 'required|string|min:10',

            // STEP 5
            'sudah_pengganti' => 'required|in:ya,belum',

            'tanggal_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya|date',
            'jam_shift_pengganti'     => 'nullable|required_if:sudah_pengganti,ya',
        ], [
            'required' => ':attribute wajib diisi.',
            'min'      => ':attribute minimal :min karakter.',
            'after_or_equal' => 'Tanggal shift tujuan tidak boleh sebelum shift asli.',
            'required_if' => ':attribute wajib diisi jika sudah ada pengganti.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        /**
         * SIMPAN KE DATABASE
         */
        Sifting::create([
            'nama_karyawan' => $request->nama_karyawan,
            'divisi_jabatan' => $request->divisi_jabatan,

            'tanggal_shift_asli'   => $request->tanggal_shift_asli,
            'jam_shift_asli'       => $request->jam_shift_asli,

            'tanggal_shift_tujuan' => $request->tanggal_shift_tujuan,
            'jam_shift_tujuan'     => $request->jam_shift_tujuan,

            'alasan' => $request->alasan,

            'sudah_pengganti' => $request->sudah_pengganti,
            'tanggal_shift_pengganti' => $request->tanggal_shift_pengganti,
            'jam_shift_pengganti'     => $request->jam_shift_pengganti,

            'status' => 'pending',
        ]);

        /**
         * REDIRECT SUCCESS
         */
        return redirect()
            ->route('sifting.index')
            ->with('success', 'Pengajuan tukar shift berhasil dikirim.');
    }

    /**
     * =========================================================
     * ADMIN / INTERNAL
     * =========================================================
     */

    public function requests()
    {
        $requests = Sifting::latest()->paginate(10);

        return view('sifting.requests', compact('requests'));
    }

    public function show($id)
    {
        $request = Sifting::findOrFail($id);

        return view('sifting.show', compact('request'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan_admin' => 'nullable|string',
        ]);

        $sifting = Sifting::findOrFail($id);
        $sifting->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function statistics()
    {
        $data = [
            'total'     => Sifting::count(),
            'pending'   => Sifting::where('status', 'pending')->count(),
            'approved'  => Sifting::where('status', 'approved')->count(),
            'rejected'  => Sifting::where('status', 'rejected')->count(),
        ];

        return view('sifting.statistics', compact('data'));
    }

    public function export()
    {
        abort(501, 'Fitur export belum diimplementasikan.');
    }
}
