<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanIzin;

class PengajuanIzinController extends Controller
{
    /**
     * Tampilkan daftar pengajuan izin
     */
    public function index()
    {
        $izin = PengajuanIzin::latest()->get();

        return view('form_pengajuan_izin.pages.index', compact('izin'));
    }

    /**
     * Tampilkan form pengajuan izin
     */
    public function create()
    {
        return view('form_pengajuan_izin.pages.create');
    }

    /**
     * Simpan data pengajuan izin
     */
    public function store(Request $request)
    {
        // fallback kalau frontend gagal set hidden input
        if (!$request->filled('jenis_izin') && $request->filled('jenis_izin_option')) {
            $request->merge([
                'jenis_izin' => $request->jenis_izin_option,
            ]);
        }

        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'divisi' => 'required|string',
            'jenis_izin' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_hari' => 'required|integer|min:1',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_telepon' => 'required|string|max:20',
            'alamat_selama_izin' => 'required|string|max:255',
        ]);

        PengajuanIzin::create($validated);

        return redirect()
            ->route('izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }
}
