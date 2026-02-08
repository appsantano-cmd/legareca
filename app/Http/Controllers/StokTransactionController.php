<?php

namespace App\Http\Controllers;

use App\Models\StokGudang;
use App\Models\StokTransaction;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Handle pagination dengan opsi "all"
        $perPage = $request->get('per_page', 10);
        
        if ($perPage === 'all') {
            $transactions = $query->get();
        } else {
            // Validasi jika per_page bukan angka, gunakan default 10
            if (!is_numeric($perPage) || $perPage <= 0) {
                $perPage = 10;
            }
            $transactions = $query->paginate($perPage)->withQueryString();
        }

        // Summary - gunakan query yang sama untuk menghitung summary
        $summaryQuery = clone $query;
        $summary = [
            'total_masuk' => $summaryQuery->where('tipe', 'masuk')->sum('jumlah'),
            'total_keluar' => $summaryQuery->where('tipe', 'keluar')->sum('jumlah'),
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
        // Ambil semua departemen
        $departemenList = Departemen::orderBy('nama_departemen')
            ->pluck('nama_departemen')
            ->toArray();

        // Jika tabel departemen kosong, gunakan data default
        if (empty($departemenList)) {
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
        }

        // Ambil semua barang tanpa filter departemen dulu
        // Ini akan ditampilkan setelah user memilih departemen
        $barangList = StokGudang::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->orderBy('nama_barang')
            ->get(['id', 'kode_barang', 'nama_barang', 'satuan', 'stok_akhir', 'departemen'])
            ->groupBy('departemen'); // Kelompokkan berdasarkan departemen

        $keperluanList = [
            'Produksi',
            'Maintenance',
            'Pemakaian Kantor',
            'Project',
            'Penjualan',
            'Lainnya'
        ];

        // Get distinct suppliers from StokGudang table (bukan dari transactions)
        $supplierList = StokGudang::whereNotNull('supplier')
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
        // Debug: Log semua request data
        \Log::info('Transaction Store Request:', $request->all());

        // Validasi dasar - departemen sekarang required untuk semua tipe
        $rules = [
            'departemen' => 'required', // Departemen required untuk semua tipe
            'tipe' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'barang' => 'required|array|min:1',
            'barang.*.kode_barang' => 'required|exists:stok_gudang,kode_barang',
            'barang.*.jumlah' => 'required|numeric|min:0.01',

            // Mode validation
            'keperluan_mode' => 'required|in:global,perbarang',
            'nama_penerima_mode' => 'required|in:global,perbarang',
            'keterangan_mode' => 'required|in:global,perbarang',
        ];

        // Validasi keperluan hanya untuk stok keluar
        if ($request->tipe == 'keluar') {
            if ($request->keperluan_mode == 'global') {
                $rules['keperluan_global'] = 'required';
            }
        }

        // Validasi nama penerima
        if ($request->nama_penerima_mode == 'global') {
            $rules['nama_penerima_global'] = 'required';
        }

        $request->validate($rules);

        \Log::info('Validation passed');

        DB::beginTransaction();

        try {
            $tanggalTransaksi = Carbon::parse($request->tanggal);
            $bulan = $tanggalTransaksi->month;
            $tahun = $tanggalTransaksi->year;

            $errors = [];
            $transactions = [];

            \Log::info('Processing ' . count($request->barang) . ' barang items');

            // Proses setiap barang
            foreach ($request->barang as $index => $barangData) {
                \Log::info("Processing barang index {$index}:", $barangData);

                $barang = StokGudang::where('kode_barang', $barangData['kode_barang'])
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                if (!$barang) {
                    \Log::warning("Barang {$barangData['kode_barang']} not found for period {$bulan}-{$tahun}");
                    // Cari data bulan sebelumnya untuk rollover atau buat baru
                    $barang = $this->findOrCreateStokForPeriod($barangData['kode_barang'], $bulan, $tahun);
                }

                // Validasi stok untuk pengeluaran
                if ($request->tipe == 'keluar') {
                    $currentStock = $barang->stok_akhir;
                    if ($currentStock < $barangData['jumlah']) {
                        $errors[] = "Stok tidak mencukupi untuk {$barang->nama_barang}! Stok tersedia: {$currentStock} {$barang->satuan}";
                        \Log::warning("Insufficient stock for {$barang->nama_barang}: {$barangData['jumlah']} > {$currentStock}");
                    }
                }

                // Data untuk transaksi - DEPARTEMEN DISIMPAN UNTUK SEMUA TIPE
                $transactionData = [
                    'stok_gudang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'tipe' => $request->tipe,
                    'jumlah' => $barangData['jumlah'],
                    'satuan' => $barang->satuan,
                    'tanggal' => $request->tanggal,
                    'departemen' => $request->departemen, // Departemen disimpan untuk semua tipe
                    'supplier' => $barangData['supplier'] ?? null, // Supplier dari barang
                ];

                // Keperluan (hanya untuk Stok Keluar)
                if ($request->tipe == 'keluar') {
                    if ($request->keperluan_mode == 'global') {
                        $transactionData['keperluan'] = $request->keperluan_global;
                    } else {
                        $transactionData['keperluan'] = $barangData['keperluan'] ?? null;
                    }
                } else {
                    // Untuk stok masuk, keperluan = null
                    $transactionData['keperluan'] = null;
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

                \Log::info("Transaction data for index {$index}:", $transactionData);
                $transactions[] = $transactionData;
            }

            // Jika ada error, kembalikan error
            if (!empty($errors)) {
                \Log::error('Validation errors:', $errors);
                DB::rollBack();
                return back()->withErrors(['stok' => $errors])->withInput();
            }

            \Log::info('Saving ' . count($transactions) . ' transactions');

            // Simpan semua transaksi
            $savedCount = 0;
            foreach ($transactions as $transactionData) {
                $transaction = StokTransaction::create($transactionData);
                \Log::info("Created transaction ID: {$transaction->id}");

                // Update stok langsung
                $barangForUpdate = StokGudang::where('kode_barang', $transactionData['kode_barang'])
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                if ($barangForUpdate) {
                    $this->updateStokGudangFromTransaction($transaction, $barangForUpdate);
                    $savedCount++;
                } else {
                    \Log::error("StokGudang not found for kode_barang: {$transactionData['kode_barang']}");
                }
            }

            DB::commit();

            \Log::info("Successfully saved {$savedCount} transactions");

            return redirect()->route('transactions.create')
                ->with('success', $savedCount . ' transaksi berhasil ditambahkan dan stok telah diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Transaction store error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
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

        // Data untuk dropdown - Ambil dari database Departemen
        $departemenList = Departemen::orderBy('nama_departemen')
            ->pluck('nama_departemen')
            ->toArray();

        // Jika tabel departemen kosong, gunakan data default
        if (empty($departemenList)) {
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
        }

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

        // Debug log
        \Log::info('Update Transaction Request:', $request->all());
        \Log::info('Original Transaction:', $transaction->toArray());

        // Validasi hanya field yang bisa diubah
        $rules = [
            'jumlah' => 'required|numeric|min:0.01',
            'nama_penerima' => 'required',
        ];

        // Validasi supplier hanya untuk stok masuk
        if ($transaction->tipe == 'masuk') {
            $rules['supplier'] = 'required';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $tanggalTransaksi = Carbon::parse($transaction->tanggal); // Tetap gunakan tanggal transaksi asli
            $bulan = $tanggalTransaksi->month;
            $tahun = $tanggalTransaksi->year;

            // Cari stok gudang yang sesuai
            $stokGudang = StokGudang::where('kode_barang', $transaction->kode_barang)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            if (!$stokGudang) {
                throw new \Exception("Stok gudang untuk barang ini tidak ditemukan!");
            }

            \Log::info('Original Stock:', [
                'stok_awal' => $stokGudang->stok_awal,
                'stok_masuk' => $stokGudang->stok_masuk,
                'stok_keluar' => $stokGudang->stok_keluar,
                'stok_akhir' => $stokGudang->stok_akhir
            ]);

            // Validasi stok untuk pengeluaran jika jumlah berubah
            if ($transaction->tipe == 'keluar' && $request->jumlah != $transaction->jumlah) {
                // Kembalikan stok lama dulu
                $stokGudang->stok_keluar -= $transaction->jumlah;
                $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;

                \Log::info('After returning original stock:', [
                    'stok_keluar' => $stokGudang->stok_keluar,
                    'stok_akhir' => $stokGudang->stok_akhir
                ]);

                // Validasi stok baru
                if ($stokGudang->stok_akhir < $request->jumlah) {
                    throw new \Exception("Stok tidak mencukupi! Stok tersedia: {$stokGudang->stok_akhir} {$stokGudang->satuan}");
                }

                // Update dengan jumlah baru
                $stokGudang->stok_keluar += $request->jumlah;
                \Log::info('After adding new stock:', [
                    'stok_keluar' => $stokGudang->stok_keluar
                ]);
            } elseif ($transaction->tipe == 'masuk' && $request->jumlah != $transaction->jumlah) {
                // Untuk stok masuk, cukup update selisihnya
                $selisih = $request->jumlah - $transaction->jumlah;
                $stokGudang->stok_masuk += $selisih;
                \Log::info('Stock masuk selisih:', [
                    'selisih' => $selisih,
                    'new_stok_masuk' => $stokGudang->stok_masuk
                ]);
            }

            // Update stok akhir
            $stokGudang->stok_akhir = $stokGudang->stok_awal + $stokGudang->stok_masuk - $stokGudang->stok_keluar;
            \Log::info('Final stock calculation:', [
                'stok_akhir' => $stokGudang->stok_akhir
            ]);

            // Validasi stok tidak boleh negatif
            if ($stokGudang->stok_akhir < 0) {
                throw new \Exception('Stok tidak boleh negatif!');
            }

            // Update data transaksi - hanya field yang boleh diubah
            $updateData = [
                'jumlah' => $request->jumlah,
                'nama_penerima' => $request->nama_penerima,
                'keterangan' => $request->keterangan ?? null,
            ];

            // Tambahkan supplier hanya untuk stok masuk
            if ($transaction->tipe == 'masuk') {
                $updateData['supplier'] = $request->supplier;
            }

            // Update nama barang jika stok gudang berubah (seharusnya tidak berubah)
            if ($stokGudang->nama_barang != $transaction->nama_barang) {
                $updateData['nama_barang'] = $stokGudang->nama_barang;
            }

            \Log::info('Updating transaction with data:', $updateData);

            $transaction->update($updateData);

            // Simpan perubahan stok
            $stokGudang->save();

            DB::commit();

            \Log::info('Transaction updated successfully');

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Update transaction error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
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
     * Method untuk mengambil data departemen via AJAX (opsional)
     */
    public function getDepartemenList(Request $request)
    {
        $search = $request->input('search', '');

        $departemenList = Departemen::when($search, function ($query, $search) {
            return $query->where('nama_departemen', 'like', "%{$search}%");
        })
            ->orderBy('nama_departemen')
            ->pluck('nama_departemen')
            ->toArray();

        // Jika tabel departemen kosong, gunakan data default
        if (empty($departemenList)) {
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
        }

        return response()->json($departemenList);
    }

    /**
     * Get barang by departemen via AJAX
     */
    public function getBarangByDepartemen(Request $request)
    {
        $departemen = $request->input('departemen');

        if (!$departemen) {
            return response()->json([]);
        }

        // Cari barang berdasarkan departemen
        $barangList = StokGudang::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->where('departemen', $departemen) // Filter by departemen
            ->orderBy('nama_barang')
            ->get(['id', 'kode_barang', 'nama_barang', 'satuan', 'stok_akhir', 'supplier']);

        return response()->json($barangList);
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

    /**
     * Export data ke Excel
     */
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'tipe' => 'nullable|in:masuk,keluar',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $tipe = $request->tipe;

        // Generate nama file
        $filename = 'transaksi_stok_';

        if ($startDate && $endDate) {
            $filename .= Carbon::parse($startDate)->format('Ymd') . '_' . Carbon::parse($endDate)->format('Ymd');
        } elseif ($startDate) {
            $filename .= 'dari_' . Carbon::parse($startDate)->format('Ymd');
        } elseif ($endDate) {
            $filename .= 'sampai_' . Carbon::parse($endDate)->format('Ymd');
        } else {
            $filename .= 'semua';
        }

        if ($tipe) {
            $filename .= '_' . $tipe;
        }

        $filename .= '.xlsx';

        return Excel::download(
            new TransactionsExport($startDate, $endDate, $tipe),
            $filename
        );
    }

    /**
     * Show export form
     */
    public function showExportForm()
    {
        return view('stok.transactions.export');
    }
}