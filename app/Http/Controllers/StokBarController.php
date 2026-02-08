<?php

namespace App\Http\Controllers;

use App\Models\StokBar;
use App\Models\StokStationMasterBar;
use App\Models\SatuanStation;
use Illuminate\Http\Request;
use App\Exports\StokBarExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon; // Tambahkan ini untuk format tanggal

class StokBarController extends Controller
{
    public function index(Request $request)
    {
        $query = StokBar::query();

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan nama bahan
        if ($request->filled('nama_bahan')) {
            $query->where('nama_bahan', 'like', '%' . $request->nama_bahan . '%');
        }

        // Filter berdasarkan shift
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        // TAMBAHAN: Filter berdasarkan status
        if ($request->filled('status_stok')) {
            $query->where('status_stok', $request->status_stok);
        }

        // Urutkan dari yang lama ke baru berdasarkan tanggal, shift, dan waktu
        $stokBar = $query->orderBy('tanggal', 'asc')
            ->orderBy('shift', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

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

        // Jika stok awal tidak diisi, ambil dari stok akhir transaksi sebelumnya
        if (!$request->filled('stok_awal')) {
            if ($request->shift == '2') {
                // Jika shift 2, cari stok akhir dari shift 1 hari yang sama
                $previousStok = StokBar::where('tanggal', $request->tanggal)
                    ->where('shift', '1')
                    ->where('kode_bahan', $request->kode_bahan)
                    ->latest()
                    ->first();

                if ($previousStok) {
                    $request->merge(['stok_awal' => $previousStok->stok_akhir]);
                } else {
                    // Jika tidak ada data sebelumnya, ambil dari master
                    $master = StokStationMasterBar::where('kode_bahan', $request->kode_bahan)->first();
                    $request->merge(['stok_awal' => $master ? $master->stok_awal : 0]);
                }
            } else {
                // Jika shift 1, cari dari shift 2 hari sebelumnya
                $previousDate = date('Y-m-d', strtotime($request->tanggal . ' -1 day'));
                $previousStok = StokBar::where('tanggal', $previousDate)
                    ->where('shift', '2')
                    ->where('kode_bahan', $request->kode_bahan)
                    ->latest()
                    ->first();

                if ($previousStok) {
                    $request->merge(['stok_awal' => $previousStok->stok_akhir]);
                } else {
                    // Jika tidak ada data sebelumnya, ambil dari master
                    $master = StokStationMasterBar::where('kode_bahan', $request->kode_bahan)->first();
                    $request->merge(['stok_awal' => $master ? $master->stok_awal : 0]);
                }
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
            'stok_minimum' => $master->stok_minimum,
            'stok_awal' => $master->stok_awal
        ]);
    }

    public function getPreviousStok(Request $request)
    {
        $tanggal = $request->tanggal;
        $kode_bahan = $request->kode_bahan;
        $shift = $request->shift;

        $master = StokStationMasterBar::where('kode_bahan', $kode_bahan)->first();

        if ($shift == '1') {
            // Untuk shift 1, ambil shift 2 hari sebelumnya
            $previousDate = date('Y-m-d', strtotime($tanggal . ' -1 day'));
            $previousShift = '2';
        } else {
            // Untuk shift 2, ambil shift 1 hari yang sama
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
                'stok_akhir' => $previousStok->stok_akhir,
                'source' => 'previous_transaction'
            ]);
        }

        // fallback ke master
        return response()->json([
            'stok_awal' => $master?->stok_awal ?? 0,
            'stok_akhir' => $master?->stok_awal ?? 0,
            'source' => 'master'
        ]);
    }

    public function searchMasterBahan(Request $request)
    {
        $search = $request->get('search');

        $masterBahan = StokStationMasterBar::where('kode_bahan', 'like', "%{$search}%")
            ->orWhere('nama_bahan', 'like', "%{$search}%")
            ->orderBy('nama_bahan')
            ->limit(20)
            ->get();

        return response()->json($masterBahan);
    }

    // Fungsi baru untuk export Excel
    public function export(Request $request)
    {
        $request->validate([
            'export_start_date' => 'required|date',
            'export_end_date' => 'required|date'
        ]);

        $startDate = $request->export_start_date;
        $endDate = $request->export_end_date;

        $fileName = 'Stok Station Harian Bar - ' . date('j F Y') . '.xlsx';

        return Excel::download(new StokBarExport($startDate, $endDate), $fileName);
    }
}