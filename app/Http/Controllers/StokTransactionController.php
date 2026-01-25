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

        return view('stok.transactions.index', compact('transactions', 'summary', 'barangList'));
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

        // Get distinct suppliers from transactions
        $supplierList = StokTransaction::where('tipe', 'masuk')
            ->whereNotNull('supplier')
            ->distinct()
            ->pluck('supplier')
            ->toArray();

        // Sort suppliers alphabetically
        sort($supplierList);

        return view('stok.transactions.create', compact(
            'barangList',
            'departemenList',
            'keperluanList',
            'supplierList'
        ));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $rules = [
            'tipe' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'barang' => 'required|array|min:1',
            'barang.*.kode_barang' => 'required|exists:stok_gudang,kode_barang',
            'barang.*.jumlah' => 'required|numeric|min:0.01',

            // Mode validation
            'supplier_mode' => 'required|in:global,perbarang',
            'departemen_mode' => 'required|in:global,perbarang',
            'keperluan_mode' => 'required|in:global,perbarang',
            'nama_penerima_mode' => 'required|in:global,perbarang',
            'keterangan_mode' => 'required|in:global,perbarang',
        ];

        // Validasi berdasarkan tipe dan mode
        if ($request->tipe == 'masuk') {
            if ($request->supplier_mode == 'global') {
                $rules['supplier_global'] = 'required';
            } else {
                // Validasi supplier per barang
                foreach ($request->barang as $index => $barang) {
                    $rules["barang.{$index}.supplier"] = 'required';
                }
            }
        } else {
            if ($request->departemen_mode == 'global') {
                $rules['departemen_global'] = 'required';
            } else {
                // Validasi departemen per barang
                foreach ($request->barang as $index => $barang) {
                    $rules["barang.{$index}.departemen"] = 'required';
                }
            }

            if ($request->keperluan_mode == 'global') {
                $rules['keperluan_global'] = 'required';
            } else {
                // Validasi keperluan per barang
                foreach ($request->barang as $index => $barang) {
                    $rules["barang.{$index}.keperluan"] = 'required';
                }
            }
        }

        // Validasi nama penerima
        if ($request->nama_penerima_mode == 'global') {
            $rules['nama_penerima_global'] = 'required';
        } else {
            // Validasi nama penerima per barang
            foreach ($request->barang as $index => $barang) {
                $rules["barang.{$index}.nama_penerima"] = 'required';
            }
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
                ];

                // Supplier (hanya untuk Stok Masuk)
                if ($request->tipe == 'masuk') {
                    if ($request->supplier_mode == 'global') {
                        // Mode Global: Gunakan supplier global
                        $transactionData['supplier'] = $request->supplier_global;
                    } else {
                        // Mode Per Barang: Gunakan supplier per barang
                        $transactionData['supplier'] = $barangData['supplier'] ?? null;
                    }
                }

                // Departemen dan Keperluan (hanya untuk Stok Keluar)
                if ($request->tipe == 'keluar') {
                    if ($request->departemen_mode == 'global') {
                        $transactionData['departemen'] = $request->departemen_global;
                    } else {
                        $transactionData['departemen'] = $barangData['departemen'] ?? null;
                    }

                    if ($request->keperluan_mode == 'global') {
                        $transactionData['keperluan'] = $request->keperluan_global;
                    } else {
                        $transactionData['keperluan'] = $barangData['keperluan'] ?? null;
                    }
                }

                // Nama Penerima
                if ($request->nama_penerima_mode == 'global') {
                    $transactionData['nama_penerima'] = $request->nama_penerima_global;
                } else {
                    $transactionData['nama_penerima'] = $barangData['nama_penerima'] ?? null;
                }

                // Keterangan
                if ($request->keterangan_mode == 'global') {
                    $transactionData['keterangan'] = $request->keterangan_global ?? null;
                } else {
                    $transactionData['keterangan'] = $barangData['keterangan'] ?? null;
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

    public function edit($id)
    {
        $transaction = StokTransaction::findOrFail($id);
        
        // Ambil data barang yang sama untuk dropdown
        $barangList = StokGudang::where('bulan', $transaction->created_at->month)
            ->where('tahun', $transaction->created_at->year)
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

        // Get distinct suppliers from transactions
        $supplierList = StokTransaction::where('tipe', 'masuk')
            ->whereNotNull('supplier')
            ->distinct()
            ->pluck('supplier')
            ->toArray();

        // Sort suppliers alphabetically
        sort($supplierList);

        return view('stok.transactions.edit', compact(
            'transaction',
            'barangList',
            'departemenList',
            'keperluanList',
            'supplierList'
        ));
    }

    public function update(Request $request, $id)
    {
        $transaction = StokTransaction::findOrFail($id);
        
        // Validasi
        $rules = [
            'tanggal' => 'required|date',
            'kode_barang' => 'required|exists:stok_gudang,kode_barang',
            'jumlah' => 'required|numeric|min:0.01',
        ];

        // Validasi tambahan berdasarkan tipe
        if ($transaction->tipe == 'masuk') {
            $rules['supplier'] = 'required';
        } else {
            $rules['departemen'] = 'required';
            $rules['keperluan'] = 'required';
        }

        $rules['nama_penerima'] = 'required';

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $tanggalTransaksi = Carbon::parse($request->tanggal);
            $bulan = $tanggalTransaksi->month;
            $tahun = $tanggalTransaksi->year;

            // Cari stok gudang yang sesuai
            $stokGudang = StokGudang::where('kode_barang', $request->kode_barang)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            if (!$stokGudang) {
                throw new \Exception("Stok gudang untuk barang ini tidak ditemukan!");
            }

            // Validasi stok untuk pengeluaran jika jumlah berubah
            if ($transaction->tipe == 'keluar' && $request->jumlah != $transaction->jumlah) {
                // Kembalikan stok lama dulu
                $stokGudang->stok_keluar -= $transaction->jumlah;
                $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;
                
                // Validasi stok baru
                if ($stokGudang->stok_akhir < $request->jumlah) {
                    throw new \Exception("Stok tidak mencukupi! Stok tersedia: {$stokGudang->stok_akhir} {$stokGudang->satuan}");
                }
                
                // Update dengan jumlah baru
                $stokGudang->stok_keluar += $request->jumlah;
            } elseif ($transaction->tipe == 'masuk' && $request->jumlah != $transaction->jumlah) {
                // Untuk stok masuk, cukup update selisihnya
                $selisih = $request->jumlah - $transaction->jumlah;
                $stokGudang->stok_masuk += $selisih;
            }

            // Update stok akhir
            $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;
            
            // Validasi stok tidak boleh negatif
            if ($stokGudang->stok_akhir < 0) {
                throw new \Exception('Stok tidak boleh negatif!');
            }

            // Update data transaksi
            $transaction->update([
                'tanggal' => $request->tanggal,
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $stokGudang->nama_barang,
                'jumlah' => $request->jumlah,
                'satuan' => $stokGudang->satuan,
                'supplier' => $transaction->tipe == 'masuk' ? $request->supplier : null,
                'departemen' => $transaction->tipe == 'keluar' ? $request->departemen : null,
                'keperluan' => $transaction->tipe == 'keluar' ? $request->keperluan : null,
                'nama_penerima' => $request->nama_penerima,
                'keterangan' => $request->keterangan,
                'stok_gudang_id' => $stokGudang->id,
            ]);

            // Simpan perubahan stok
            $stokGudang->save();

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui transaksi: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $transaction = StokTransaction::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Dapatkan stok gudang terkait
            $stokGudang = StokGudang::where('kode_barang', $transaction->kode_barang)
                ->where('bulan', $transaction->created_at->month)
                ->where('tahun', $transaction->created_at->year)
                ->first();
            
            if ($stokGudang) {
                // Kembalikan stok
                if ($transaction->tipe == 'masuk') {
                    $stokGudang->stok_masuk -= $transaction->jumlah;
                } else {
                    $stokGudang->stok_keluar -= $transaction->jumlah;
                }
                
                // Update stok akhir
                $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;
                $stokGudang->save();
            }
            
            // Hapus transaksi
            $transaction->delete();
            
            DB::commit();
            
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transactions.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
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
}