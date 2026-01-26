<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::orderBy('nama_satuan')->get();
        return view('stok.satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('stok.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan,nama_satuan',
        ]);

        Satuan::create($request->all());

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit(Satuan $satuan)
    {
        return view('stok.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan,nama_satuan,' . $satuan->id,
        ]);

        $satuan->update($request->all());

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Satuan $satuan)
    {
        // Cek apakah satuan digunakan di barang
        if ($satuan->barang()->count() > 0) {
            return redirect()->route('satuan.index')
                ->with('error', 'Satuan tidak dapat dihapus karena masih digunakan oleh beberapa barang.');
        }

        $satuan->delete();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan,nama_satuan',
        ]);

        try {
            $satuan = Satuan::create([
                'nama_satuan' => $request->nama_satuan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil ditambahkan',
                'data' => $satuan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan satuan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk API
    public function getSatuanForApi()
    {
        $satuan = Satuan::orderBy('nama_satuan')->get();
        return response()->json($satuan);
    }

    public function indexApi()
    {
        $satuan = Satuan::orderBy('nama_satuan')->get();
        return response()->json($satuan);
    }
}