<?php

namespace App\Http\Controllers;

use App\Models\StokGudang;
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
        $query = StokGudang::query();

        // Filter by selected date (created_at)
        if ($request->has('selected_date') && !empty(trim($request->selected_date))) {
            try {
                // Pastikan format tanggal YYYY-MM-DD
                $selectedDate = Carbon::createFromFormat('Y-m-d', $request->selected_date);

                // Validasi tanggal
                if ($selectedDate->format('Y-m-d') === $request->selected_date) {
                    $query->whereDate('created_at', $selectedDate);
                } else {
                    // Log warning jika format tidak tepat
                    \Log::warning('Invalid date format in filter: ' . $request->selected_date);
                }
            } catch (\Exception $e) {
                // Tanggal tidak valid, tidak melakukan filter
                \Log::warning('Failed to parse date: ' . $request->selected_date . ' - ' . $e->getMessage());
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
        $perPage = 10; // default

        if ($request->has('per_page')) {
            if ($request->per_page == 'all') {
                $perPage = $query->count(); // tampilkan semua data
            } elseif (is_numeric($request->per_page) && $request->per_page > 0) {
                $perPage = $request->per_page;
            }
        }

        // Jika per_page = 'all', gunakan simplePaginate agar tetap ada navigation
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

        $tahunList = range(date('Y') - 5, date('Y') + 1);

        return view('stok.index', compact('stok', 'bulanList', 'tahunList'));
    }

    public function create()
    {
        // Generate kode otomatis
        $kodeBarang = $this->generateKodeBarang();
        
        return view('stok.create', compact('kodeBarang'));
    }

    public function store(Request $request)
    {
        // Debug: Lihat data yang diterima
        \Log::info('Data yang diterima dari form:', $request->all());
        
        $request->validate([
            'nama_barang' => 'required',
            'ukuran_barang' => 'required',
            'satuan' => 'required|exists:satuan,nama_satuan',
            'stok_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            // Ambil bulan dan tahun dari tanggal saat ini (server time)
            $now = Carbon::now();
            $bulan = $now->month;
            $tahun = $now->year;
            
            // Generate kode barang jika tidak ada (untuk keamanan)
            $kodeBarang = $request->kode_barang ?: $this->generateKodeBarang();
            
            // Cek apakah kode sudah ada untuk bulan dan tahun yang sama
            $existing = StokGudang::where('kode_barang', $kodeBarang)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();
                
            if ($existing) {
                // Jika sudah ada, generate kode baru
                $kodeBarang = $this->generateKodeBarang();
            }
            
            // GABUNGKAN NAMA BARANG DAN UKURAN
            $namaBarangFinal = trim($request->nama_barang) . ' ' . strtoupper(trim($request->ukuran_barang));
            
            // Log untuk debugging
            \Log::info('Nama barang final: ' . $namaBarangFinal);
            \Log::info('Ukuran barang: ' . $request->ukuran_barang);

            $stok = StokGudang::create([
                'kode_barang' => $kodeBarang,
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'stok_awal' => $request->stok_awal,
                'stok_masuk' => 0, // SELALU 0, karena transaksi via sistem harian
                'stok_keluar' => 0, // SELALU 0, karena transaksi via sistem harian
                'stok_akhir' => $request->stok_awal, // Sama dengan stok awal
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tanggal_submit' => $now,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil ditambahkan. Kode: ' . $kodeBarang . ', Nama: ' . $namaBarangFinal . ', Stok awal: ' . $request->stok_awal);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error menyimpan data: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $stok = StokGudang::findOrFail($id);
        
        // Pisahkan nama barang dan ukuran untuk form edit
        $namaBarang = $stok->nama_barang;
        $ukuranBarang = '';
        
        // Coba pisahkan nama barang dan ukuran (asumsi ukuran di akhir setelah spasi)
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

        return view('stok.edit', compact('stok', 'namaBarang', 'ukuranBarang', 'bulanList', 'tahunList'));
    }

    public function update(Request $request, $id)
    {
        $stok = StokGudang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required',
            'ukuran_barang' => 'required',
            'satuan' => 'required|exists:satuan,nama_satuan',
            'stok_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            // GABUNGKAN NAMA BARANG DAN UKURAN
            $namaBarangFinal = trim($request->nama_barang) . ' ' . strtoupper(trim($request->ukuran_barang));
            
            // Hitung ulang stok akhir berdasarkan stok awal yang baru
            $stok_akhir = $request->stok_awal + $stok->stok_masuk - $stok->stok_keluar;

            $stok->update([
                'nama_barang' => $namaBarangFinal,
                'satuan' => $request->satuan,
                'stok_awal' => $request->stok_awal,
                'stok_akhir' => $stok_akhir,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil diperbarui.');

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
            $stok->delete();
            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data barang berhasil dihapus.');

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
    
    /**
     * Generate kode barang otomatis dengan format AA001, AA002, dst.
     * Thread-safe untuk multi-user.
     */
    private function generateKodeBarang()
    {
        $prefix = 'AA';
        $year = date('Y');
        $month = date('m');
        
        // Cari kode terakhir dengan prefix yang sama untuk bulan dan tahun ini
        $lastCode = StokGudang::where('kode_barang', 'like', $prefix . '%')
            ->where('bulan', $month)
            ->where('tahun', $year)
            ->orderByRaw('CAST(SUBSTRING(kode_barang, 3) AS UNSIGNED) DESC')
            ->value('kode_barang');
        
        if ($lastCode) {
            // Ekstrak angka dari kode terakhir
            $lastNumber = (int) substr($lastCode, 2);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada kode untuk bulan ini, mulai dari 1
            $nextNumber = 1;
        }
        
        // Format dengan leading zeros (3 digit)
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $formattedNumber;
    }
}