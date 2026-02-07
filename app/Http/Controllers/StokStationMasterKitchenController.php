<?php

namespace App\Http\Controllers;

use App\Models\StokStationMasterKitchen;
use App\Models\SatuanStation;
use Illuminate\Http\Request;
use App\Exports\MasterKitchenExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini

class StokStationMasterKitchenController extends Controller
{
    public function index(Request $request)
    {
        $query = StokStationMasterKitchen::query();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan nama bahan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_bahan', 'like', "%{$search}%")
                    ->orWhere('kode_bahan', 'like', "%{$search}%");
            });
        }

        $masterKitchen = $query->orderBy('created_at', 'desc')->get();
        $satuan = SatuanStation::orderBy('nama_satuan')->get();

        return view('stok_station.master_kitchen', compact('masterKitchen', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_awal' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        // Generate kode bahan otomatis
        $lastCode = StokStationMasterKitchen::orderBy('id', 'desc')->first();
        $nextNumber = $lastCode ? intval(substr($lastCode->kode_bahan, 2)) + 1 : 1;
        $kodeBahan = 'MA' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Tambahkan kode bahan ke data request
        $request->merge(['kode_bahan' => $kodeBahan]);

        StokStationMasterKitchen::create($request->all());

        return redirect()->route('master-kitchen.index')
            ->with('success', 'Master bahan kitchen berhasil ditambahkan.');
    }

    public function update(Request $request, StokStationMasterKitchen $masterKitchen)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_awal' => 'required|numeric|min:0',
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

    // Tambahkan method export baru
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');

        // Format nama file
        $today = Carbon::now();

        $bulan = $today->locale('id')->monthName;
        $tahun = $today->format('Y');
        $tanggal = $today->format('d');

        $fileName = "Master Stok Station Kitchen - " . $tanggal . " ". $bulan . " " . $tahun . ".xlsx";


        return Excel::download(new MasterKitchenExport($startDate, $endDate), $fileName);
    }
}