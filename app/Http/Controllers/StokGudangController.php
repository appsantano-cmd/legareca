<?php

namespace App\Http\Controllers;

use App\Models\StokGudang;
use App\Models\StokRolloverHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokGudangExport;

class StokGudangController extends Controller
{
    public function index(Request $request)
    {
        $query = StokGudang::query();
        
        // Filter by bulan dan tahun
        if ($request->has('bulan') && $request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        
        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        
        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }
        
        $stok = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $tahunList = range(date('Y') - 5, date('Y') + 1);
        
        return view('stok.index', compact('stok', 'bulanList', 'tahunList'));
    }

    public function create()
    {
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $tahunList = range(date('Y') - 5, date('Y') + 1);
        
        return view('stok.create', compact('bulanList', 'tahunList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:stok_gudang,kode_barang',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'stok_awal' => 'required|numeric|min:0',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'keterangan' => 'nullable'
        ]);

        DB::beginTransaction();
        
        try {
            $stok = StokGudang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'stok_awal' => $request->stok_awal,
                'stok_masuk' => 0, // SELALU 0, karena transaksi via sistem harian
                'stok_keluar' => 0, // SELALU 0, karena transaksi via sistem harian
                'stok_akhir' => $request->stok_awal, // Sama dengan stok awal
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();
            
            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil ditambahkan. Stok awal: ' . $request->stok_awal);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function rollover()
    {
        $result = StokGudang::rolloverToNextMonth();
        
        if ($result['success']) {
            return redirect()->route('stok.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->route('stok.index')
                ->with('error', $result['message']);
        }
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $filename = 'stok-gudang-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d') . '.xlsx';

        return Excel::download(new StokGudangExport($startDate, $endDate), $filename);
    }

    public function showRolloverHistory()
    {
        $history = StokRolloverHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('stok.history-rollover', compact('history'));
    }
}