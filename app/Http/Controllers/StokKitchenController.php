<?php

namespace App\Http\Controllers;

use App\Models\StokKitchen;
use App\Models\StokStationMasterKitchen;
use App\Models\SatuanStation;
use Illuminate\Http\Request;
use App\Exports\StokKitchenExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StokKitchenController extends Controller
{
    public function index(Request $request)
    {
        $query = StokKitchen::query();

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

        // Filter berdasarkan status (TAMBAHAN: Filter status)
        if ($request->filled('status_stok')) {
            $query->where('status_stok', $request->status_stok);
        }

        // Urutkan dari yang lama ke baru berdasarkan tanggal, shift, dan waktu
        $stokKitchen = $query->orderBy('tanggal', 'asc')
            ->orderBy('shift', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

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

        // Jika stok awal tidak diisi, ambil dari stok akhir transaksi sebelumnya
        if (!$request->filled('stok_awal')) {
            if ($request->shift == '2') {
                // Jika shift 2, cari stok akhir dari shift 1 hari yang sama
                $previousStok = StokKitchen::where('tanggal', $request->tanggal)
                    ->where('shift', '1')
                    ->where('kode_bahan', $request->kode_bahan)
                    ->latest()
                    ->first();

                if ($previousStok) {
                    $request->merge(['stok_awal' => $previousStok->stok_akhir]);
                } else {
                    // Jika tidak ada data sebelumnya, ambil dari master
                    $master = StokStationMasterKitchen::where('kode_bahan', $request->kode_bahan)->first();
                    $request->merge(['stok_awal' => $master ? $master->stok_awal : 0]);
                }
            } else {
                // Jika shift 1, cari dari shift 2 hari sebelumnya
                $previousDate = date('Y-m-d', strtotime($request->tanggal . ' -1 day'));
                $previousStok = StokKitchen::where('tanggal', $previousDate)
                    ->where('shift', '2')
                    ->where('kode_bahan', $request->kode_bahan)
                    ->latest()
                    ->first();

                if ($previousStok) {
                    $request->merge(['stok_awal' => $previousStok->stok_akhir]);
                } else {
                    // Jika tidak ada data sebelumnya, ambil dari master
                    $master = StokStationMasterKitchen::where('kode_bahan', $request->kode_bahan)->first();
                    $request->merge(['stok_awal' => $master ? $master->stok_awal : 0]);
                }
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
            'stok_minimum' => $master->stok_minimum,
            'stok_awal' => $master->stok_awal
        ]);
    }

    public function getPreviousStok(Request $request)
    {
        $tanggal = $request->tanggal;
        $kode_bahan = $request->kode_bahan;
        $shift = $request->shift;

        $master = StokStationMasterKitchen::where('kode_bahan', $kode_bahan)->first();

        if ($shift == '1') {
            // Untuk shift 1, ambil shift 2 hari sebelumnya
            $previousDate = date('Y-m-d', strtotime($tanggal . ' -1 day'));
            $previousShift = '2';
        } else {
            // Untuk shift 2, ambil shift 1 hari yang sama
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

        $masterBahan = StokStationMasterKitchen::where('kode_bahan', 'like', "%{$search}%")
            ->orWhere('nama_bahan', 'like', "%{$search}%")
            ->orderBy('nama_bahan')
            ->limit(20)
            ->get();

        return response()->json($masterBahan);
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');
        $namaBahan = $request->nama_bahan;
        $shift = $request->shift;
        $statusStok = $request->status_stok; // TAMBAHAN: Filter status untuk export

        // Format nama file sesuai permintaan
        $startDateFormatted = Carbon::parse($request->start_date)->locale('id')->translatedFormat('d F Y'); // 07 Januari 2026
        $endDateFormatted = Carbon::parse($request->end_date)->locale('id')->translatedFormat('d F Y'); // 10 Februari 2026

        if ($startDate == $endDate) {
            // Jika tanggal sama, gunakan format: Stok Station Harian Kitchen - 07 Januari 2026.xlsx
            $fileName = "Stok Station Harian Kitchen - " . $startDateFormatted . ".xlsx";
        } else {
            // Jika range tanggal, gunakan format: Stok Station Harian Kitchen - 07 Januari 2026 - 10 Februari 2026.xlsx
            $fileName = "Stok Station Harian Kitchen - " . $startDateFormatted . " - " . $endDateFormatted . ".xlsx";
        }

        return Excel::download(
            new StokKitchenExport($startDate, $endDate, $namaBahan, $shift, $statusStok), // TAMBAHAN: Parameter status
            $fileName
        );
    }
}