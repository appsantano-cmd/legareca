<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = Departemen::orderBy('nama_departemen')->get();
        return view('stok.departemen.index', compact('departemen'));
    }

    public function create()
    {
        return view('stok.departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemen,nama_departemen',
        ]);

        Departemen::create($request->all());

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Departemen $departemen)
    {
        return view('stok.departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemen,nama_departemen,' . $departemen->id,
        ]);

        $departemen->update($request->all());

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Departemen $departemen)
    {
        // Cek apakah departemen digunakan di transaksi
        if ($departemen->transactions()->count() > 0) {
            return redirect()->route('departemen.index')
                ->with('error', 'Departemen tidak dapat dihapus karena masih digunakan oleh beberapa transaksi.');
        }

        $departemen->delete();

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}