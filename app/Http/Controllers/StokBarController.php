<?php

namespace App\Http\Controllers;

use App\Models\StokBar;
use App\Models\StokStationMasterBar;
use App\Models\SatuanStation;
use Illuminate\Http\Request;

class StokBarController extends Controller
{
    public function index()
    {
        $stokBar = StokBar::latest()->get();
        $masterBar = StokStationMasterBar::all();
        $satuan = SatuanStation::all();
        return view('stok_station.bar', compact('stokBar', 'masterBar', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'shift' => 'required|in:1,2',
            'kode_bahan' => 'required|string|max:50',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_awal' => 'required|numeric|min:0',
            'stok_masuk' => 'nullable|numeric|min:0',
            'stok_keluar' => 'nullable|numeric|min:0',
            'waste' => 'nullable|numeric|min:0',
            'alasan_waste' => 'nullable|string',
            'pic' => 'required|string|max:100'
        ]);

        // Cari stok akhir dari transaksi sebelumnya untuk shift yang sama
        if ($request->shift == '2') {
            // Jika shift 2, cari stok akhir dari shift 1 hari yang sama
            $previousStok = StokBar::where('tanggal', $request->tanggal)
                ->where('shift', '1')
                ->where('kode_bahan', $request->kode_bahan)
                ->latest()
                ->first();
            
            if ($previousStok) {
                $request->merge(['stok_awal' => $previousStok->stok_akhir]);
            }
        }

        StokBar::create($request->all());

        return redirect()->route('stok-bar.index')
            ->with('success', 'Stok bar berhasil ditambahkan.');
    }

    public function update(Request $request, StokBar $stokBar)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'shift' => 'required|in:1,2',
            'kode_bahan' => 'required|string|max:50',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_awal' => 'required|numeric|min:0',
            'stok_masuk' => 'nullable|numeric|min:0',
            'stok_keluar' => 'nullable|numeric|min:0',
            'waste' => 'nullable|numeric|min:0',
            'alasan_waste' => 'nullable|string',
            'pic' => 'required|string|max:100'
        ]);

        $stokBar->update($request->all());

        return redirect()->route('stok-bar.index')
            ->with('success', 'Stok bar berhasil diperbarui.');
    }

    public function destroy(StokBar $stokBar)
    {
        $stokBar->delete();

        return redirect()->route('stok-bar.index')
            ->with('success', 'Stok bar berhasil dihapus.');
    }

    public function getMasterBahan($kode_bahan)
    {
        $master = StokStationMasterBar::where('kode_bahan', $kode_bahan)->first();
        
        if (!$master) {
            return response()->json(['error' => 'Master bahan tidak ditemukan'], 404);
        }

        return response()->json([
            'kode_bahan' => $master->kode_bahan,
            'nama_bahan' => $master->nama_bahan,
            'nama_satuan' => $master->nama_satuan,
            'stok_minimum' => $master->stok_minimum
        ]);
    }

    public function getPreviousStok($tanggal, $kode_bahan, $shift)
    {
        if ($shift == '1') {
            // Untuk shift 1, cari dari hari sebelumnya shift 2
            $previousDate = date('Y-m-d', strtotime($tanggal . ' -1 day'));
            $previousShift = '2';
        } else {
            // Untuk shift 2, cari dari shift 1 hari yang sama
            $previousDate = $tanggal;
            $previousShift = '1';
        }

        $previousStok = StokBar::where('tanggal', $previousDate)
            ->where('shift', $previousShift)
            ->where('kode_bahan', $kode_bahan)
            ->latest()
            ->first();

        if ($previousStok) {
            return response()->json([
                'stok_awal' => $previousStok->stok_akhir,
                'stok_akhir' => $previousStok->stok_akhir
            ]);
        }

        return response()->json(['stok_awal' => 0, 'stok_akhir' => 0]);
    }
}