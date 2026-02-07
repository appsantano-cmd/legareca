<?php

namespace App\Http\Controllers;

use App\Models\StokStationMasterBar;
use App\Models\SatuanStation;
use Illuminate\Http\Request;
use App\Exports\MasterBarExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini

class StokStationMasterBarController extends Controller
{
    public function index(Request $request)
    {
        $query = StokStationMasterBar::query();

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

        $masterBar = $query->latest()->get();

        // Tambahkan status stok untuk setiap item
        $masterBar->each(function ($item) {
            $item->status_stok = $item->stok_awal >= $item->stok_minimum ? 'SAFE' : 'REORDER';
        });

        $satuan = SatuanStation::all();

        return view('stok_station.master_bar', compact('masterBar', 'satuan'));
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
        $lastCode = StokStationMasterBar::orderBy('id', 'desc')->first();
        $nextNumber = $lastCode ? intval(substr($lastCode->kode_bahan, 2)) + 1 : 1;
        $kodeBahan = 'MI' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Tambahkan kode bahan ke data request
        $request->merge(['kode_bahan' => $kodeBahan]);

        StokStationMasterBar::create($request->all());

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil ditambahkan.');
    }

    public function update(Request $request, StokStationMasterBar $masterBar)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_bahan' => 'required|string|max:100',
            'nama_satuan' => 'required|string|max:50',
            'stok_awal' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0'
        ]);

        $masterBar->update($request->all());

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil diperbarui.');
    }

    public function destroy(StokStationMasterBar $masterBar)
    {
        $masterBar->delete();

        return redirect()->route('master-bar.index')
            ->with('success', 'Master bahan bar berhasil dihapus.');
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

        $fileName = "Master Stok Station Bar - " . $tanggal . " " . $bulan . " " . $tahun . ".xlsx";

        return Excel::download(new MasterBarExport($startDate, $endDate), $fileName);
    }
}