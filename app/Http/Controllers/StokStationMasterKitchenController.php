<?php

namespace App\Http\Controllers;

use App\Models\StokStationMasterKitchen;
use App\Models\SatuanStation;
use Illuminate\Http\Request;

class StokStationMasterKitchenController extends Controller
{
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Gunakan model yang benar sesuai dengan yang di-import
        $masterKitchen = StokStationMasterKitchen::orderBy('created_at', 'desc')->get();
        $satuan = SatuanStation::orderBy('nama_satuan')->get();

        return view('stok_station.master_kitchen', compact('masterKitchen', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kode_bahan' => 'required|string|max:50|unique:stok_stations_master_kitchen,kode_bahan',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        // Tambahkan status_stok default
        $data = $request->all();
        $data['status_stok'] = 'SAFE'; // atau logika penentuan status
        
        StokStationMasterKitchen::create($data);

        return redirect()->route('master-kitchen.index')
            ->with('success', 'Master bahan kitchen berhasil ditambahkan.');
    }

    public function update(Request $request, StokStationMasterKitchen $masterKitchen)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kode_bahan' => 'required|string|max:50|unique:stok_stations_master_kitchen,kode_bahan,' . $masterKitchen->id,
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        $masterKitchen->update($request->all());

        return redirect()->route('master-kitchen.index')
            ->with('success', 'Master bahan kitchen berhasil diperbarui.');
    }

    public function destroy(StokStationMasterKitchen $masterKitchen)
    {
        $masterKitchen->delete();

        return redirect()->route('master-kitchen.index')
            ->with('success', 'Master bahan kitchen berhasil dihapus.');
    }
}