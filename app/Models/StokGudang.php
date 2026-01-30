<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StokGudang extends Model
{
    use HasFactory;

    protected $table = 'stok_gudang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'departemen',
        'supplier',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_akhir',
        'bulan',
        'tahun',
        'tanggal_submit',
        'is_rollover',
        'keterangan'
    ];

    protected $casts = [
        'stok_awal' => 'decimal:2',
        'stok_masuk' => 'decimal:2',
        'stok_keluar' => 'decimal:2',
        'stok_akhir' => 'decimal:2',
        'tanggal_submit' => 'datetime',
        'is_rollover' => 'boolean'
    ];

    public function masterStok()
    {
        return $this->belongsTo(MasterStokGudang::class, 'kode_barang', 'kode_barang');
    }

    // Relasi dengan transaksi
    public function transactions()
    {
        return $this->hasMany(StokTransaction::class, 'kode_barang', 'kode_barang');
    }

    /**
     * Melakukan rollover stok ke bulan berikutnya
     */
    public static function rolloverToNextMonth()
    {
        try {
            $now = now();
            $currentMonth = $now->month;
            $currentYear = $now->year;

            // Hitung bulan dan tahun berikutnya
            $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
            $nextYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;

            \Log::info("Rollover dari: $currentMonth/$currentYear ke: $nextMonth/$nextYear");

            // Cek apakah sudah ada data untuk bulan berikutnya
            $existingNextMonth = self::where('bulan', $nextMonth)
                ->where('tahun', $nextYear)
                ->exists();

            if ($existingNextMonth) {
                \Log::warning("Data untuk $nextMonth/$nextYear sudah ada!");
                return [
                    'success' => false,
                    'message' => 'Data untuk bulan ' . $nextMonth . '/' . $nextYear . ' sudah ada!'
                ];
            }

            // Ambil stok bulan ini
            $currentStocks = self::where('bulan', $currentMonth)
                ->where('tahun', $currentYear)
                ->where('is_rollover', false)
                ->get();

            if ($currentStocks->isEmpty()) {
                \Log::warning("Tidak ada data untuk $currentMonth/$currentYear");
                return [
                    'success' => false,
                    'message' => 'Tidak ada data stok untuk bulan ' . $currentMonth . '/' . $currentYear
                ];
            }

            DB::beginTransaction();

            $rolloverData = [];
            $totalItems = 0;

            foreach ($currentStocks as $stock) {
                // Generate kode baru untuk bulan berikutnya (sama dengan bulan ini)
                $newStock = self::create([
                    'kode_barang' => $stock->kode_barang,
                    'nama_barang' => $stock->nama_barang,
                    'satuan' => $stock->satuan,
                    'departemen' => $stock->departemen,
                    'supplier' => $stock->supplier,
                    'stok_awal' => $stock->stok_akhir, // Stok akhir bulan ini menjadi stok awal bulan berikutnya
                    'stok_masuk' => 0,
                    'stok_keluar' => 0,
                    'stok_akhir' => $stock->stok_akhir,
                    'bulan' => $nextMonth,
                    'tahun' => $nextYear,
                    'tanggal_submit' => $now,
                    'is_rollover' => true,
                    'keterangan' => "Rollover dari {$stock->bulan}/{$stock->tahun}"
                ]);

                // Tandai stok lama sebagai sudah di-rollover
                $stock->update(['is_rollover' => true]);

                $rolloverData[] = [
                    'barang' => $stock->nama_barang,
                    'stok' => $stock->stok_akhir,
                    'from' => "{$stock->bulan}/{$stock->tahun}",
                    'to' => "{$nextMonth}/{$nextYear}"
                ];

                $totalItems++;
            }

            // Simpan history rollover
            DB::table('stok_rollover_history')->insert([
                'from_bulan' => $currentMonth,
                'from_tahun' => $currentYear,
                'to_bulan' => $nextMonth,
                'to_tahun' => $nextYear,
                'total_barang' => $totalItems,
                'total_nilai' => $currentStocks->sum('stok_akhir'),
                'catatan' => 'Rollover otomatis sistem',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            \Log::info("=== ROLLOVER SUCCESS: $totalItems items ===");

            return [
                'success' => true,
                'message' => "Berhasil melakukan rollover {$totalItems} barang dari {$currentMonth}/{$currentYear} ke {$nextMonth}/{$nextYear}",
                'data' => $rolloverData
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("=== ROLLOVER FAILED: " . $e->getMessage() . " ===");
            return [
                'success' => false,
                'message' => 'Gagal melakukan rollover: ' . $e->getMessage()
            ];
        }
    }

    public static function calculateStokAkhir()
    {
        return DB::raw('stok_awal + stok_masuk - stok_keluar');
    }

    public function updateStokAkhir()
    {
        $this->stok_akhir = $this->stok_awal + $this->stok_masuk - $this->stok_keluar;
        $this->save();
    }

    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        return $query->where(function ($q) use ($startDate, $endDate) {
            $q->whereYear('created_at', '>=', $startDate->year)
                ->whereMonth('created_at', '>=', $startDate->month)
                ->whereYear('created_at', '<=', $endDate->year)
                ->whereMonth('created_at', '<=', $endDate->month);
        });
    }

    /**
     * Get stok untuk periode tertentu
     */
    public static function getStokForPeriod($kodeBarang, $bulan, $tahun)
    {
        return self::where('kode_barang', $kodeBarang)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
    }

    /**
     * Get current stock for a barang
     */
    public static function getCurrentStock($kodeBarang)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $stok = self::where('kode_barang', $kodeBarang)
            ->where('bulan', $currentMonth)
            ->where('tahun', $currentYear)
            ->first();

        return $stok ? $stok->stok_akhir : 0;
    }

    /**
     * Update stok from transaction (legacy method - tetap dipertahankan untuk kompatibilitas)
     */
    public static function updateFromTransaction($transaction)
    {
        $stok = self::where('kode_barang', $transaction->kode_barang)
            ->where('bulan', $transaction->tanggal->month)
            ->where('tahun', $transaction->tanggal->year)
            ->first();

        if (!$stok) {
            // Cari info barang
            $barangInfo = self::where('kode_barang', $transaction->kode_barang)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$barangInfo) {
                throw new \Exception("Barang dengan kode {$transaction->kode_barang} tidak ditemukan.");
            }

            $stok = self::create([
                'kode_barang' => $transaction->kode_barang,
                'nama_barang' => $barangInfo->nama_barang,
                'satuan' => $barangInfo->satuan,
                'stok_awal' => 0,
                'stok_masuk' => 0,
                'stok_keluar' => 0,
                'stok_akhir' => 0,
                'bulan' => $transaction->tanggal->month,
                'tahun' => $transaction->tanggal->year,
                'tanggal_submit' => now(),
                'is_rollover' => false,
                'keterangan' => 'Dibuat dari transaksi'
            ]);
        }

        // Update berdasarkan tipe
        if ($transaction->tipe == 'masuk') {
            $stok->stok_masuk += $transaction->jumlah;
        } else {
            $stok->stok_keluar += $transaction->jumlah;
        }

        $stok->stok_akhir = $stok->stok_awal + $stok->stok_masuk - $stok->stok_keluar;

        if ($stok->stok_akhir < 0) {
            throw new \Exception('Stok tidak boleh negatif!');
        }

        $stok->save();

        return $stok;
    }
}