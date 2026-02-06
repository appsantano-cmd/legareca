<?php

namespace App\Http\Controllers;

use App\Models\StokKitchen;
use App\Models\StokStationMasterKitchen;
use App\Models\SatuanStation;
use Illuminate\Http\Request;

class StokKitchenController extends Controller
{
    public function index()
    {
        $stokKitchen = StokKitchen::latest()->get();
        $masterKitchen = StokStationMasterKitchen::all();
        $satuan = SatuanStation::all();
        return view('stok_station.kitchen', compact('stokKitchen', 'masterKitchen', 'satuan'));
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
            $previousStok = StokKitchen::where('tanggal', $request->tanggal)
                ->where('shift', '1')
                ->where('kode_bahan', $request->kode_bahan)
                ->latest()
                ->first();
            
            if ($previousStok) {
                $request->merge(['stok_awal' => $previousStok->stok_akhir]);
            }
        }

        StokKitchen::create($request->all());

        return redirect()->route('stok-kitchen.index')
            ->with('success', 'Stok kitchen berhasil ditambahkan.');
    }

    public function update(Request $request, StokKitchen $stokKitchen)
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

        $stokKitchen->update($request->all());

        return redirect()->route('stok-kitchen.index')
            ->with('success', 'Stok kitchen berhasil diperbarui.');
    }

    public function destroy(StokKitchen $stokKitchen)
    {
        $stokKitchen->delete();

        return redirect()->route('stok-kitchen.index')
            ->with('success', 'Stok kitchen berhasil dihapus.');
    }

    public function getMasterBahan($kode_bahan)
    {
        $master = StokStationMasterKitchen::where('kode_bahan', $kode_bahan)->first();
        
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

        $previousStok = StokKitchen::where('tanggal', $previousDate)
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