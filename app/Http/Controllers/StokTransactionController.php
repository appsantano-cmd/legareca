<?php

namespace App\Http\Controllers;

use App\Models\StokGudang;
use App\Models\StokTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = StokTransaction::with('stokGudang')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            // Default: hari ini
            $query->where('tanggal', today());
        }

        // Filter by tipe
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by supplier (untuk stok masuk)
        if ($request->filled('supplier')) {
            $query->where('supplier', 'like', "%{$request->supplier}%");
        }

        // Filter by departemen (untuk stok keluar)
        if ($request->filled('departemen')) {
            $query->where('departemen', 'like', "%{$request->departemen}%");
        }

        // Filter by barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(20);

        // Summary
        $summary = [
            'total_masuk' => (clone $query)->where('tipe', 'masuk')->sum('jumlah'),
            'total_keluar' => (clone $query)->where('tipe', 'keluar')->sum('jumlah'),
        ];

        // Get all barang for dropdown
        $barangList = StokGudang::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->orderBy('nama_barang')
            ->get(['id', 'kode_barang', 'nama_barang', 'satuan', 'stok_akhir']);

        return view('transactions.index', compact('transactions', 'summary', 'barangList'));
    }

    public function create()
    {
        $barangList = StokGudang::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->orderBy('nama_barang')
            ->get(['id', 'kode_barang', 'nama_barang', 'satuan', 'stok_akhir']);

        // Data untuk dropdown
        $departemenList = [
            'Produksi',
            'Gudang',
            'Logistik',
            'IT',
            'HRD',
            'Keuangan',
            'Marketing',
            'Maintenance',
            'Lainnya'
        ];

        $keperluanList = [
            'Produksi',
            'Maintenance',
            'Pemakaian Kantor',
            'Project',
            'Penjualan',
            'Lainnya'
        ];

        $supplierList = StokTransaction::where('tipe', 'masuk')
            ->whereNotNull('supplier')
            ->distinct()
            ->pluck('supplier')
            ->toArray();

        return view('transactions.create', compact(
            'barangList',
            'departemenList',
            'keperluanList',
            'supplierList'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'tipe' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'nama_penerima' => 'required',
            'keterangan' => 'nullable',
            'barang' => 'required|array|min:1',
            'barang.*.kode_barang' => 'required|exists:stok_gudang,kode_barang',
            'barang.*.jumlah' => 'required|numeric|min:0.01',
        ];

        // Validasi tambahan berdasarkan tipe
        if ($request->tipe == 'masuk') {
            $rules['supplier'] = 'required';
        } else {
            $rules['departemen'] = 'required';
            $rules['keperluan'] = 'required';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $tanggalTransaksi = Carbon::parse($request->tanggal);
            $bulan = $tanggalTransaksi->month;
            $tahun = $tanggalTransaksi->year;

            $errors = [];
            $transactions = [];

            // Proses setiap barang
            foreach ($request->barang as $index => $barangData) {
                $barang = StokGudang::where('kode_barang', $barangData['kode_barang'])
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                if (!$barang) {
                    // Cari data bulan sebelumnya untuk rollover atau buat baru
                    $barang = $this->findOrCreateStokForPeriod($barangData['kode_barang'], $bulan, $tahun);
                }

                // Validasi stok untuk pengeluaran
                if ($request->tipe == 'keluar') {
                    $currentStock = $barang->stok_akhir;
                    if ($currentStock < $barangData['jumlah']) {
                        $errors[] = "Stok tidak mencukupi untuk {$barang->nama_barang}! Stok tersedia: {$currentStock} {$barang->satuan}";
                    }
                }

                // Data untuk transaksi
                $transactionData = [
                    'stok_gudang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'tipe' => $request->tipe,
                    'jumlah' => $barangData['jumlah'],
                    'satuan' => $barang->satuan,
                    'tanggal' => $request->tanggal,
                    'nama_penerima' => $request->nama_penerima,
                    'keterangan' => $request->keterangan,
                ];

                // Tambahkan field berdasarkan tipe
                if ($request->tipe == 'masuk') {
                    $transactionData['supplier'] = $request->supplier;
                } else {
                    $transactionData['departemen'] = $request->departemen;
                    $transactionData['keperluan'] = $request->keperluan;
                }

                $transactions[] = $transactionData;
            }

            // Jika ada error, kembalikan error
            if (!empty($errors)) {
                DB::rollBack();
                return back()->withErrors(['stok' => $errors])->withInput();
            }

            // Simpan semua transaksi
            foreach ($transactions as $transactionData) {
                $transaction = StokTransaction::create($transactionData);

                // Update stok langsung
                $barangForUpdate = StokGudang::where('kode_barang', $transactionData['kode_barang'])
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                $this->updateStokGudangFromTransaction($transaction, $barangForUpdate);
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', count($transactions) . ' transaksi berhasil ditambahkan dan stok telah diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update stok gudang dari transaksi
     */
    private function updateStokGudangFromTransaction($transaction, $stokGudang)
    {
        // Update kolom stok_masuk atau stok_keluar berdasarkan tipe
        if ($transaction->tipe == 'masuk') {
            $stokGudang->stok_masuk += $transaction->jumlah;
        } else {
            $stokGudang->stok_keluar += $transaction->jumlah;
        }
        // Update stok akhir
        $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;

        // Validasi stok tidak boleh negatif
        if ($stokGudang->stok_akhir < 0) {
            throw new \Exception('Stok tidak boleh negatif!');
        }

        $stokGudang->save();

        \Log::info("Updated stok_gudang for {$transaction->kode_barang}: " .
            "stok_masuk={$stokGudang->stok_masuk}, " .
            "stok_keluar={$stokGudang->stok_keluar}, " .
            "stok_akhir={$stokGudang->stok_akhir}");
    }

    /**
     * Mencari atau membuat stok untuk periode tertentu
     */
    private function findOrCreateStokForPeriod($kodeBarang, $bulan, $tahun)
    {
        // Cari data barang terbaru untuk mendapatkan info nama dan satuan
        $barangInfo = StokGudang::where('kode_barang', $kodeBarang)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$barangInfo) {
            throw new \Exception("Barang dengan kode {$kodeBarang} tidak ditemukan di sistem.");
        }

        // Buat stok untuk periode ini
        $stok = StokGudang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $barangInfo->nama_barang,
            'satuan' => $barangInfo->satuan,
            'stok_awal' => 0,
            'stok_masuk' => 0,
            'stok_keluar' => 0,
            'stok_akhir' => 0,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'is_rollover' => false,
            'keterangan' => "Dibuat otomatis dari transaksi"
        ]);

        return $stok;
    }

    public function show($id)
    {
        $transaction = StokTransaction::with('stokGudang')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function laporanHarian(Request $request)
    {
        $date = $request->get('tanggal', today()->format('Y-m-d'));

        $transactions = StokTransaction::with('stokGudang')
            ->where('tanggal', $date)
            ->orderBy('tipe')
            ->orderBy('created_at')
            ->get();

        $summary = [
            'masuk' => $transactions->where('tipe', 'masuk')->sum('jumlah'),
            'keluar' => $transactions->where('tipe', 'keluar')->sum('jumlah'),
            'total_transaksi' => $transactions->count()
        ];

        return view('transactions.laporan-harian', compact('transactions', 'summary', 'date'));
    }

    public function rekapitulasi(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $transactions = StokTransaction::with('stokGudang')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // Group by barang
        $rekapitulasi = [];
        foreach ($transactions as $transaction) {
            $kode = $transaction->kode_barang;

            if (!isset($rekapitulasi[$kode])) {
                $rekapitulasi[$kode] = [
                    'nama_barang' => $transaction->nama_barang,
                    'satuan' => $transaction->satuan,
                    'masuk' => 0,
                    'keluar' => 0,
                    'transactions' => []
                ];
            }

            if ($transaction->tipe == 'masuk') {
                $rekapitulasi[$kode]['masuk'] += $transaction->jumlah;
            } else {
                $rekapitulasi[$kode]['keluar'] += $transaction->jumlah;
            }

            $rekapitulasi[$kode]['transactions'][] = $transaction;
        }

        // Sort by nama barang
        ksort($rekapitulasi);

        return view('transactions.rekapitulasi', compact('rekapitulasi', 'startDate', 'endDate'));
    }
}