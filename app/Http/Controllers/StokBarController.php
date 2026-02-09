<?php

namespace App\Http\Controllers;

use App\Models\StokBar;
use App\Models\StokStationMasterBar;
use App\Models\SatuanStation;
use Illuminate\Http\Request;
use App\Exports\StokBarExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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

        // Simpan data (stok_akhir dan status_stok akan dihitung otomatis di model)
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

        // Update data (stok_akhir dan status_stok akan dihitung otomatis di model)
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

        // LOGIC PERBAIKAN: Cari transaksi terakhir dengan prioritas yang lebih baik
        // 1. Cari di hari yang sama, shift yang sama (transaksi sebelumnya dalam shift yang sama)
        // 2. Cari di hari yang sama, shift sebelumnya (jika shift 2, cari shift 1)
        // 3. Cari di hari sebelumnya, shift 2 (jika shift 1)
        // 4. Cari di hari sebelumnya, shift 1 (jika shift 2)
        // 5. Cari transaksi terakhir apapun (tanpa filter tanggal/shift)
        // 6. Jika tidak ada, ambil dari master

        $query = StokBar::where('kode_bahan', $kode_bahan);

        // 1. Hari yang sama, shift yang sama (untuk multiple transactions dalam shift yang sama)
        $sameShiftTransaction = $query->clone()
            ->whereDate('tanggal', $tanggal)
            ->where('shift', $shift)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($sameShiftTransaction) {
            return response()->json([
                'stok_awal' => $sameShiftTransaction->stok_akhir,
                'stok_akhir' => $sameShiftTransaction->stok_akhir,
                'source' => 'same_shift_transaction',
                'tanggal_transaksi' => $sameShiftTransaction->tanggal->format('Y-m-d'),
                'shift_transaksi' => $sameShiftTransaction->shift,
                'waktu_transaksi' => $sameShiftTransaction->created_at->format('H:i'),
                'previous_id' => $sameShiftTransaction->id
            ]);
        }

        // 2. Hari yang sama, shift sebelumnya
        $previousShift = ($shift == '2') ? '1' : '2';
        $sameDayPreviousShift = $query->clone()
            ->whereDate('tanggal', $tanggal)
            ->where('shift', $previousShift)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($sameDayPreviousShift) {
            return response()->json([
                'stok_awal' => $sameDayPreviousShift->stok_akhir,
                'stok_akhir' => $sameDayPreviousShift->stok_akhir,
                'source' => 'previous_shift_same_day',
                'tanggal_transaksi' => $sameDayPreviousShift->tanggal->format('Y-m-d'),
                'shift_transaksi' => $sameDayPreviousShift->shift,
                'waktu_transaksi' => $sameDayPreviousShift->created_at->format('H:i'),
                'previous_id' => $sameDayPreviousShift->id
            ]);
        }

        // 3. Hari sebelumnya, shift 2 (khusus untuk shift 1 hari ini)
        if ($shift == '1') {
            $previousDate = date('Y-m-d', strtotime($tanggal . ' -1 day'));
            $previousDayShift2 = $query->clone()
                ->whereDate('tanggal', $previousDate)
                ->where('shift', '2')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($previousDayShift2) {
                return response()->json([
                    'stok_awal' => $previousDayShift2->stok_akhir,
                    'stok_akhir' => $previousDayShift2->stok_akhir,
                    'source' => 'previous_day_shift_2',
                    'tanggal_transaksi' => $previousDayShift2->tanggal->format('Y-m-d'),
                    'shift_transaksi' => $previousDayShift2->shift,
                    'waktu_transaksi' => $previousDayShift2->created_at->format('H:i'),
                    'previous_id' => $previousDayShift2->id
                ]);
            }
        }

        // 4. Hari sebelumnya, shift 1 (khusus untuk shift 2 hari ini)
        if ($shift == '2') {
            $previousDate = date('Y-m-d', strtotime($tanggal . ' -1 day'));
            $previousDayShift1 = $query->clone()
                ->whereDate('tanggal', $previousDate)
                ->where('shift', '1')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($previousDayShift1) {
                return response()->json([
                    'stok_awal' => $previousDayShift1->stok_akhir,
                    'stok_akhir' => $previousDayShift1->stok_akhir,
                    'source' => 'previous_day_shift_1',
                    'tanggal_transaksi' => $previousDayShift1->tanggal->format('Y-m-d'),
                    'shift_transaksi' => $previousDayShift1->shift,
                    'waktu_transaksi' => $previousDayShift1->created_at->format('H:i'),
                    'previous_id' => $previousDayShift1->id
                ]);
            }
        }

        // 5. Cari transaksi terakhir apapun (tanpa filter tanggal/shift)
        $anyPreviousTransaction = $query->clone()
            ->orderBy('tanggal', 'desc')
            ->orderBy('shift', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($anyPreviousTransaction) {
            return response()->json([
                'stok_awal' => $anyPreviousTransaction->stok_akhir,
                'stok_akhir' => $anyPreviousTransaction->stok_akhir,
                'source' => 'any_previous_transaction',
                'tanggal_transaksi' => $anyPreviousTransaction->tanggal->format('Y-m-d'),
                'shift_transaksi' => $anyPreviousTransaction->shift,
                'waktu_transaksi' => $anyPreviousTransaction->created_at->format('H:i'),
                'previous_id' => $anyPreviousTransaction->id
            ]);
        }

        // 6. Fallback ke master jika tidak ada transaksi sebelumnya sama sekali
        return response()->json([
            'stok_awal' => $master?->stok_awal ?? 0,
            'stok_akhir' => $master?->stok_awal ?? 0,
            'source' => 'master',
            'tanggal_transaksi' => null,
            'shift_transaksi' => null,
            'waktu_transaksi' => null,
            'previous_id' => null
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

    public function export(Request $request)
    {
        $request->validate([
            'export_start_date' => 'required|date',
            'export_end_date' => 'required|date'
        ]);

        $startDate = $request->export_start_date;
        $endDate = $request->export_end_date;

        // Format nama file sesuai permintaan
        $startDateFormatted = Carbon::parse($request->export_start_date)->locale('id')->translatedFormat('d F Y');
        $endDateFormatted = Carbon::parse($request->export_end_date)->locale('id')->translatedFormat('d F Y');

        if ($startDate == $endDate) {
            $fileName = "Stok Station Harian Bar - " . $startDateFormatted . ".xlsx";
        } else {
            $fileName = "Stok Station Harian Bar - " . $startDateFormatted . " - " . $endDateFormatted . ".xlsx";
        }

        return Excel::download(new StokBarExport($startDate, $endDate), $fileName);
    }
}