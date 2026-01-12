<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Repositories\PengajuanIzinSheetRepository;
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
    $validated = $request->validate([
        'nama'   => 'required|string|max:100',
        'divisi' => 'required|string',

        'jenis_izin_pilihan' => 'required|string',
        'jenis_izin_lainnya' => 'nullable|string|max:100',

        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'jumlah_hari' => 'required|integer|min:1',
        'keterangan_tambahan' => 'nullable|string',
        'nomor_telepon' => 'required|string|max:20',
        'alamat' => 'required|string|max:255',
        'konfirmasi' => 'required|accepted',
        'documen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // 🔥 LOGIKA FINAL JENIS IZIN
    if ($validated['jenis_izin_pilihan'] === 'Lainnya') {
        if (!$request->filled('jenis_izin_lainnya')) {
            return back()
                ->withErrors(['jenis_izin_lainnya' => 'Jenis izin lainnya wajib diisi'])
                ->withInput();
        }

        $validated['jenis_izin'] = $validated['jenis_izin_lainnya'];
    } else {
        $validated['jenis_izin'] = $validated['jenis_izin_pilihan'];
    }

    unset($validated['jenis_izin_pilihan'], $validated['jenis_izin_lainnya']);

    // simpan file
    if ($request->hasFile('documen_pendukung')) {
        $validated['documen_pendukung'] =
            $request->file('documen_pendukung')
                ->store('izin_pendukung', 'public');
    }

    DB::transaction(function () use ($validated) {
        // 1️⃣ Simpan ke database
        $izin = PengajuanIzin::create([
            ...$validated,
            'status' => 'Pending',
        ]);

        // 2️⃣ Langsung sync ke Google Sheet
        $repo = new PengajuanIzinSheetRepository();
        $repo->appendSingle($izin);
    });

    return redirect()
        ->route('izin.index')
        ->with('success', 'Pengajuan izin berhasil dikirim');
}


}
