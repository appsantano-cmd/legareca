<?php

namespace App\Http\Controllers;

use App\Models\SatuanStation;
use Illuminate\Http\Request;

class SatuanStationController extends Controller
{
    public function index()
    {
        $satuan = SatuanStation::all();
        return view('stok_station.satuan', compact('satuan'));
    }

    public function create()
    {
        return view('stok_station.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_stations'
        ]);

        SatuanStation::create($request->all());

        return redirect()->route('satuan-station.index')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit(SatuanStation $satuanStation)
    {
        return view('stok_station.satuan.edit', compact('satuanStation'));
    }

    public function update(Request $request, SatuanStation $satuanStation)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_stations,nama_satuan,' . $satuanStation->id
        ]);

        $satuanStation->update($request->all());

        return redirect()->route('satuan-station.index')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(SatuanStation $satuanStation)
    {
        $satuanStation->delete();

        return redirect()->route('satuan-station.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }
}