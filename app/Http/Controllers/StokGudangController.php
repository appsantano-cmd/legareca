<?php

namespace App\Http\Controllers;

use App\Models\StokGudang;
use App\Models\MasterStokGudang;
use App\Models\StokRolloverHistory;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokGudangExport;

class StokGudangController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan tipe data yang diminta
        $dataType = $request->get('type', 'stok'); // 'stok' atau 'master'

        if ($dataType === 'master') {
            return $this->masterIndex($request);
        }

        return $this->stokIndex($request);
    }

    private function stokIndex(Request $request)
    {
        $query = StokGudang::query();

        // Filter by selected date (created_at) - FIXED
        if ($request->filled('selected_date')) {
            $selectedDate = trim($request->selected_date);

            // Hanya filter jika tanggal valid dan tidak kosong
            if ($selectedDate !== '' && $selectedDate !== '0000-00-00' && $selectedDate !== '1970-01-01') {
                try {
                    // Validasi format tanggal YYYY-MM-DD
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
                        $parsedDate = Carbon::createFromFormat('Y-m-d', $selectedDate);
                        // Pastikan parsing berhasil dan tanggal valid
                        if ($parsedDate && $parsedDate->format('Y-m-d') === $selectedDate) {
                            $query->whereDate('created_at', $parsedDate);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to parse date: ' . $selectedDate . ' - ' . $e->getMessage());
                }
            }
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        // Tentukan jumlah data per halaman
        $perPage = 10;
        if ($request->has('per_page')) {
            if ($request->per_page == 'all') {
                $perPage = $query->count();
            } elseif (is_numeric($request->per_page) && $request->per_page > 0) {
                $perPage = $request->per_page;
            }
        }

        // Tambahkan debug logging untuk melihat query
        \Log::info('Stok Query:', [
            'selected_date' => $request->selected_date,
            'search' => $request->search,
            'per_page' => $perPage,
            'count' => $query->count(),
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        if ($request->per_page == 'all') {
            $stok = $query->orderBy('created_at', 'desc')->simplePaginate($perPage)->withQueryString();
        } else {
            $stok = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        }

        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $dataType = 'stok';

        return view('stok.index', compact('stok', 'bulanList', 'dataType'));
    }

    private function masterIndex(Request $request)
    {
        $query = MasterStokGudang::query();

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('departemen', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        // Tentukan jumlah data per halaman
        $perPage = 10;
        if ($request->has('per_page')) {
            if ($request->per_page == 'all') {
                $perPage = $query->count();
            } elseif (is_numeric($request->per_page) && $request->per_page > 0) {
                $perPage = $request->per_page;
            }
        }

        if ($request->per_page == 'all') {
            $masterStok = $query->orderBy('kode_barang', 'asc')->simplePaginate($perPage)->withQueryString();
        } else {
            $masterStok = $query->orderBy('kode_barang', 'asc')->paginate($perPage)->withQueryString();
        }

        $dataType = 'master';

        return view('stok.index', compact('masterStok', 'dataType'));
    }

    public function create()
    {
        // Generate kode otomatis dari master
        $kodeBarang = $this->generateKodeBarangFromMaster();

        return view('stok.create', compact('kodeBarang'));
    }

    public function store(Request $request)
    {
        \Log::info('Data yang diterima dari form:', $request->all());

        $request->validate([
            'nama_barang' => 'required',
            'ukuran_barang' => 'required',
            'satuan' => 'required|exists:satuan,nama_satuan',
            'departemen' => 'required',
            'supplier' => 'required',
            'stok_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            // GABUNGKAN NAMA BARANG DAN UKURAN
            $namaBarangFinal = trim($request->nama_barang) . ' ' . strtoupper(trim($request->ukuran_barang));

            // Generate kode barang
            $kodeBarang = $request->kode_barang ?: $this->generateKodeBarangFromMaster();

            $now = Carbon::now();
            $bulan = $now->month;
            $tahun = $now->year;

            // 1. SIMPAN KE MASTER STOK GUDANG
            $masterStok = MasterStokGudang::create([
                'kode_barang' => $kodeBarang,
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'departemen' => $request->departemen,
                'supplier' => $request->supplier,
                'stok_awal' => $request->stok_awal,
                'tanggal_submit' => $now
            ]);

            // 2. SIMPAN KE STOK GUDANG (DETAIL BULANAN)
            $stok = StokGudang::create([
                'kode_barang' => $kodeBarang,
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'stok_awal' => $request->stok_awal,
                'stok_masuk' => 0,
                'stok_keluar' => 0,
                'stok_akhir' => $request->stok_awal,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tanggal_submit' => $now,
                'keterangan' => $request->keterangan,
                'departemen' => $request->departemen,
                'supplier' => $request->supplier
            ]);

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil ditambahkan ke master dan detail bulanan. Kode: ' . $kodeBarang);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error menyimpan data: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $stok = StokGudang::findOrFail($id);

        // Cari data master untuk mendapatkan departemen dan supplier
        $masterStok = MasterStokGudang::where('kode_barang', $stok->kode_barang)->first();

        // Pisahkan nama barang dan ukuran untuk form edit
        $namaBarang = $stok->nama_barang;
        $ukuranBarang = '';

        if (preg_match('/(.*)\s+([A-Z0-9\s]+)$/', $namaBarang, $matches)) {
            $namaBarang = trim($matches[1]);
            $ukuranBarang = trim($matches[2]);
        }

        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $tahunList = range(date('Y') - 5, date('Y') + 1);

        return view('stok.edit', compact('stok', 'masterStok', 'namaBarang', 'ukuranBarang', 'bulanList', 'tahunList'));
    }

    public function update(Request $request, $id)
    {
        $stok = StokGudang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required',
            'ukuran_barang' => 'required',
            'satuan' => 'required|exists:satuan,nama_satuan',
            'departemen' => 'required',
            'supplier' => 'required',
            'stok_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            // GABUNGKAN NAMA BARANG DAN UKURAN
            $namaBarangFinal = trim($request->nama_barang) . ' ' . strtoupper(trim($request->ukuran_barang));

            // Hitung ulang stok akhir
            $stok_akhir = $request->stok_awal + $stok->stok_masuk - $stok->stok_keluar;

            // Update stok detail
            $stok->update([
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'stok_awal' => $request->stok_awal,
                'stok_akhir' => $stok_akhir,
                'departemen' => $request->departemen,
                'supplier' => $request->supplier,
                'keterangan' => $request->keterangan
            ]);

            // Update master stok
            MasterStokGudang::where('kode_barang', $stok->kode_barang)->update([
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'departemen' => $request->departemen,
                'supplier' => $request->supplier,
                'stok_awal' => $request->stok_awal
            ]);

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil diperbarui di master dan detail.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $stok = StokGudang::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus dari detail stok
            $stok->delete();

            // Hapus dari master stok (soft delete)
            MasterStokGudang::where('kode_barang', $stok->kode_barang)->delete();

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil dihapus dari master dan detail.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
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
            'end_date' => 'required|date|after_or_equal:start_date',
            'export_type' => 'required|in:detail,master'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $exportType = $request->export_type;

        if ($exportType === 'master') {
            $filename = 'master-stok-gudang-' . Carbon::now()->format('Y-m-d') . '.xlsx';
        } else {
            $filename = 'stok-detail-gudang-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d') . '.xlsx';
        }

        return Excel::download(new StokGudangExport($startDate, $endDate, $exportType), $filename);
    }

    public function showRolloverHistory()
    {
        $history = StokRolloverHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('stok.history-rollover', compact('history'));
    }

    /**
     * Generate kode barang otomatis dari master
     */
    private function generateKodeBarangFromMaster()
    {
        $prefix = 'AA';

        // Cari kode terakhir dari master
        $lastCode = MasterStokGudang::withTrashed()
            ->where('kode_barang', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(kode_barang, 3) AS UNSIGNED) DESC')
            ->value('kode_barang');

        if ($lastCode) {
            $lastNumber = (int) substr($lastCode, 2);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }
}