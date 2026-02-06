<?php

namespace App\Http\Controllers;

use App\Models\StokStationMasterBar;
use App\Models\SatuanStation;
use Illuminate\Http\Request;

class StokStationMasterBarController extends Controller
{
    public function index()
    {
        $masterBar = StokStationMasterBar::latest()->get();
        $satuan = SatuanStation::all(); // Masih diperlukan untuk dropdown
        return view('stok_station.master_bar', compact('masterBar', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kode_bahan' => 'required|string|max:50|unique:stok_stations_master_bar,kode_bahan',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        StokStationMasterBar::create($request->all());

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil ditambahkan.');
    }

    public function update(Request $request, StokStationMasterBar $masterBar)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kode_bahan' => 'required|string|max:50|unique:stok_stations_master_bar,kode_bahan,' . $masterBar->id,
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        $masterBar->update($request->all());

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil diperbarui.');
    }

    public function destroy(StokStationMasterBar $masterBar)
    {
        // Tidak perlu cek relasi karena struktur berubah
        $masterBar->delete();

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil dihapus.');
    }
}