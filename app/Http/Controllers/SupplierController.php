<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showDeleted = $request->has('show_deleted') && $request->show_deleted == 'true';
        
        if ($showDeleted) {
            $suppliers = Supplier::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } else {
            $suppliers = Supplier::orderBy('created_at', 'asc')->get();
        }
        
        return view('stok.supplier.index', compact('suppliers', 'showDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stok.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|unique:supplier,nama_supplier|max:255',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::withTrashed()->findOrFail($id);
        return view('stok.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::withTrashed()->findOrFail($id);
        
        if ($supplier->deleted_at) {
            return redirect()->route('supplier.index', ['show_deleted' => true])
                ->with('error', 'Tidak dapat mengedit supplier yang telah dihapus. Restore terlebih dahulu.');
        }
        
        return view('stok.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $request->validate([
            'nama_supplier' => 'required|unique:supplier,nama_supplier,' . $id . '|max:255',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }

    /**
     * Restore soft deleted supplier.
     */
    public function restore($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->restore();

        return redirect()->route('supplier.index', ['show_deleted' => true])
            ->with('success', 'Supplier berhasil direstore.');
    }

    /**
     * Force delete supplier permanently.
     */
    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->forceDelete();

        return redirect()->route('supplier.index', ['show_deleted' => true])
            ->with('success', 'Supplier berhasil dihapus permanen.');
    }

    /**
     * API endpoint for suppliers.
     */
    public function indexApi()
    {
        $suppliers = Supplier::withTrashed()->orderBy('nama_supplier')->get();
        return response()->json($suppliers);
    }
}