<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource (hanya data aktif).
     */
    public function index()
    {
        // Ambil hanya data yang tidak dihapus (soft delete)
        $barangMasuk = BarangMasuk::orderBy('tanggal_masuk', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total stok per barang hanya dari data aktif
        $stokBarang = BarangMasuk::selectRaw('nama_barang, satuan, SUM(jumlah_masuk) as total_stok')
            ->groupBy('nama_barang', 'satuan')
            ->get()
            ->keyBy('nama_barang');

        // Ambil data unik untuk dropdown hanya dari data aktif
        $suppliers = BarangMasuk::select('supplier')
            ->distinct()
            ->orderBy('supplier')
            ->pluck('supplier');

        $barangList = BarangMasuk::select('nama_barang', 'satuan')
            ->distinct()
            ->orderBy('nama_barang')
            ->get();

        // Ambil data satuan dari tabel satuan - HAPUS FILTER STATUS
        $satuan = Satuan::orderBy('satuan_input')->get();

        // Hitung jumlah data di trash
        $trashCount = BarangMasuk::onlyTrashed()->count();

        return view('stock.barangMasuk.index', compact(
            'barangMasuk',
            'stokBarang',
            'suppliers',
            'barangList',
            'trashCount',
            'satuan'
        ));
    }

    /**
     * Display trashed (soft deleted) items.
     */
    public function trash()
    {
        // Ambil data yang dihapus (soft delete)
        $trashedItems = BarangMasuk::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('stock.barangMasuk.trash', compact('trashedItems'));
    }

    /**
     * Store multiple items at once.
     */
    public function storeMultiple(Request $request)
    {
        // Validasi input untuk multiple items
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.tanggal_masuk' => 'required|date',
            'items.*.supplier' => 'required|string|max:255',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.jumlah_masuk' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $savedItems = [];

            foreach ($request->items as $item) {
                // 1. Simpan data barang masuk
                $barangMasuk = BarangMasuk::create([
                    'tanggal_masuk' => $item['tanggal_masuk'],
                    'supplier' => $item['supplier'],
                    'nama_barang' => $item['nama_barang'],
                    'jumlah_masuk' => $item['jumlah_masuk'],
                    'satuan' => $item['satuan'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                // 2. Update stok di tabel barang
                $this->updateStokBarang($item['nama_barang'], $item['jumlah_masuk'], 'masuk');

                $savedItems[] = $barangMasuk;
            }

            DB::commit();

            // Auto-sync to Google Sheets after saving
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => count($savedItems) . ' item berhasil disimpan! Stok berhasil diperbarui.',
                'data' => $savedItems,
                'count' => count($savedItems)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in storeMultiple: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $barangMasuk = BarangMasuk::findOrFail($id);

            // Simpan data sebelum dihapus untuk update stok
            $namaBarang = $barangMasuk->nama_barang;
            $jumlah = $barangMasuk->jumlah_masuk;

            // 1. Kembalikan stok (keluar)
            $this->updateStokBarang($namaBarang, $jumlah, 'keluar');

            // 2. Hapus data (soft delete)
            $barangMasuk->delete();

            DB::commit();

            // Auto-sync to Google Sheets after deletion
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data stok masuk berhasil dihapus (dipindahkan ke trash)! Stok berhasil disesuaikan.',
                'trash_count' => BarangMasuk::onlyTrashed()->count()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in destroy: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore soft deleted item.
     */
    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $barangMasuk = BarangMasuk::withTrashed()->findOrFail($id);

            if ($barangMasuk->trashed()) {
                // Simpan data untuk update stok
                $namaBarang = $barangMasuk->nama_barang;
                $jumlah = $barangMasuk->jumlah_masuk;

                // 1. Tambah stok kembali (masuk)
                $this->updateStokBarang($namaBarang, $jumlah, 'masuk');

                // 2. Restore data
                $barangMasuk->restore();

                DB::commit();

                // Auto-sync to Google Sheets after restore
                $this->autoSyncToSheets();

                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dipulihkan! Stok berhasil ditambahkan.',
                    'trash_count' => BarangMasuk::onlyTrashed()->count()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak berada di trash.'
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in restore: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memulihkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force delete (permanent delete) the specified resource.
     */
    public function forceDelete($id)
    {
        try {
            $barangMasuk = BarangMasuk::withTrashed()->findOrFail($id);
            $barangMasuk->forceDelete();

            // Auto-sync to Google Sheets after force delete
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus permanen!',
                'trash_count' => BarangMasuk::onlyTrashed()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data permanen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore all trashed items.
     */
    public function restoreAll()
    {
        try {
            $restoredCount = BarangMasuk::onlyTrashed()->restore();

            // Auto-sync to Google Sheets after restore all
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => $restoredCount . ' data berhasil dipulihkan!',
                'count' => $restoredCount,
                'trash_count' => BarangMasuk::onlyTrashed()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memulihkan semua data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Empty trash (permanent delete all trashed items).
     */
    public function emptyTrash()
    {
        try {
            $trashedCount = BarangMasuk::onlyTrashed()->count();
            BarangMasuk::onlyTrashed()->forceDelete();

            // Auto-sync to Google Sheets after emptying trash
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Trash berhasil dikosongkan! ' . $trashedCount . ' data dihapus permanen.',
                'count' => $trashedCount,
                'trash_count' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengosongkan trash: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('barang-masuk.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_masuk' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $barangMasuk = BarangMasuk::create($request->all());

            // Update stok barang
            $this->updateStokBarang($request->nama_barang, $request->jumlah_masuk, 'masuk');

            DB::commit();

            // Auto-sync to Google Sheets after creating
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data stok masuk berhasil disimpan! Stok berhasil diperbarui.',
                'data' => $barangMasuk
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        return response()->json($barangMasuk);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $barangMasuk = BarangMasuk::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $barangMasuk
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_masuk' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Simpan data lama untuk perhitungan selisih
            $oldNamaBarang = $barangMasuk->nama_barang;
            $oldJumlah = $barangMasuk->jumlah_masuk;

            $newNamaBarang = $request->nama_barang;
            $newJumlah = $request->jumlah_masuk;

            // 1. Kembalikan stok lama (keluar)
            if ($oldNamaBarang === $newNamaBarang) {
                // Jika nama barang sama, hitung selisih
                $selisih = $newJumlah - $oldJumlah;
                if ($selisih != 0) {
                    $this->updateStokBarang($oldNamaBarang, abs($selisih), $selisih > 0 ? 'masuk' : 'keluar');
                }
            } else {
                // Jika nama barang berbeda
                // Kembalikan stok lama (keluar)
                $this->updateStokBarang($oldNamaBarang, $oldJumlah, 'keluar');
                // Tambah stok baru (masuk)
                $this->updateStokBarang($newNamaBarang, $newJumlah, 'masuk');
            }

            // 2. Update data barang masuk
            $barangMasuk->update($request->all());

            DB::commit();

            // Auto-sync to Google Sheets after update
            $this->autoSyncToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data stok masuk berhasil diperbarui! Stok berhasil disesuaikan.',
                'data' => $barangMasuk
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in update: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for select2 dropdown (supplier)
     */
    public function getSuppliers()
    {
        $suppliers = BarangMasuk::select('supplier')
            ->distinct()
            ->orderBy('supplier')
            ->pluck('supplier');

        return response()->json($suppliers);
    }

    /**
     * Get data for select2 dropdown (nama barang)
     */
    public function getBarang()
    {
        $barang = BarangMasuk::select('nama_barang', 'satuan')
            ->distinct()
            ->orderBy('nama_barang')
            ->get();

        return response()->json($barang);
    }

    /**
     * Get barang data for modal
     */
    public function getBarangData(Request $request)
    {
        try {
            $query = Barang::query();

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('kode_barang', 'LIKE', "%{$search}%")
                        ->orWhere('nama_barang', 'LIKE', "%{$search}%");
                });
            }

            // Get only active barang by default
            $query->where('status', true);

            // Order by
            $query->orderBy('nama_barang')
                ->orderBy('kode_barang');

            $barang = $query->get([
                'id',
                'kode_barang',
                'nama_barang',
                'satuan_utama',
                'stok_sekarang',
                'status'
            ]);

            return response()->json([
                'success' => true,
                'barang' => $barang,
                'count' => $barang->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getBarangData: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data barang: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get satuan data for modal/dropdown
     */
    public function getSatuanData(Request $request)
    {
        try {
            $query = Satuan::query();

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('satuan_input', 'LIKE', "%{$search}%")
                        ->orWhere('satuan_utama', 'LIKE', "%{$search}%");
                });
            }

            // Order by
            $query->orderBy('satuan_input');

            // Ambil data sesuai struktur tabel yang benar
            $satuan = $query->get([
                'id',
                'satuan_input',
                'satuan_utama',
                'faktor'
            ]);

            return response()->json([
                'success' => true,
                'satuan' => $satuan,
                'count' => $satuan->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getSatuanData: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data satuan: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to update stok barang.
     */
    private function updateStokBarang($namaBarang, $jumlah, $type = 'masuk')
    {
        try {
            // Cari semua barang dengan nama yang sama
            $barangItems = Barang::where('nama_barang', $namaBarang)
                ->where('status', true)
                ->orderBy('stok_sekarang', 'desc') // Prioritaskan yang stoknya lebih besar
                ->get();

            if ($barangItems->isEmpty()) {
                throw new \Exception("Barang dengan nama '{$namaBarang}' tidak ditemukan atau tidak aktif");
            }

            $sisaJumlah = $jumlah;

            foreach ($barangItems as $barang) {
                if ($sisaJumlah <= 0)
                    break;

                if ($type === 'masuk') {
                    // Tambah stok
                    $barang->stok_sekarang += $sisaJumlah;
                    $sisaJumlah = 0;
                } else {
                    // Kurangi stok
                    if ($barang->stok_sekarang >= $sisaJumlah) {
                        $barang->stok_sekarang -= $sisaJumlah;
                        $sisaJumlah = 0;
                    } else {
                        $sisaJumlah -= $barang->stok_sekarang;
                        $barang->stok_sekarang = 0;
                    }
                }

                $barang->save();
            }

            // Jika masih ada sisa untuk pengurangan (stok tidak cukup)
            if ($type === 'keluar' && $sisaJumlah > 0) {
                throw new \Exception("Stok barang '{$namaBarang}' tidak mencukupi. Sisa kebutuhan: {$sisaJumlah}");
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Error in updateStokBarang: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Auto-sync data Barang Masuk ke Google Sheets
     * Dipanggil otomatis setelah CRUD operations
     */
    private function autoSyncToSheets()
    {
        try {
            // Set Google Application Credentials
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . realpath(env('GOOGLE_APPLICATION_CREDENTIALS')));

            // Setup Google Client
            $client = new \Google\Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

            $service = new \Google\Service\Sheets($client);
            Sheets::setService($service);

            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

            // 1. Ambil data Barang Masuk dengan relasi
            $barangMasuk = BarangMasuk::withTrashed()
                ->orderBy('tanggal_masuk', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // 2. Susun array rows
            $rows = [];
            $rows[] = [
                'Timestamp',
                'Tanggal Masuk',
                'Supplier',
                'Nama Barang',
                'Jumlah Masuk',
                'Satuan Input',
                'Keterangan',
                'Satuan Utama',
                'Faktor Konversi',
                'Jumlah Konversi',
                'Kode Barang',
                'Status' // Tambah kolom status (Aktif/Trash)
            ];

            foreach ($barangMasuk as $bm) {
                // Cari data barang untuk mendapatkan satuan utama, faktor konversi, dan kode barang
                $barangData = Barang::where('nama_barang', $bm->nama_barang)
                    ->where('status', true)
                    ->first();

                // Hitung jumlah konversi jika ada data satuan
                $jumlahKonversi = 0;
                $satuanUtama = '-';
                $faktorKonversi = 0;
                $kodeBarang = '-';

                if ($barangData) {
                    $kodeBarang = $barangData->kode_barang;
                    $satuanUtama = $barangData->satuan_utama;

                    // Cari faktor konversi dari tabel satuan
                    $satuan = Satuan::where('satuan_input', $bm->satuan)
                        ->where('satuan_utama', $barangData->satuan_utama)
                        ->first();

                    if ($satuan) {
                        $faktorKonversi = $satuan->faktor;
                        $jumlahKonversi = $bm->jumlah_masuk * $faktorKonversi;
                        $satuanUtama = $barangData->satuan_utama;
                    }
                }

                // Tentukan status
                $status = 'Aktif';
                if ($bm->trashed()) {
                    $status = 'Trash';
                }

     // Format tanggal masuk ke d-m-Y
            $tanggalMasukFormatted = '-';
            if ($bm->tanggal_masuk) {
                try {
                    // Parse tanggal dan format ke d-m-Y
                    $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $bm->tanggal_masuk);
                    $tanggalMasukFormatted = $tanggal->format('d-m-Y');
                } catch (\Exception $e) {
                    // Jika format Y-m-d gagal, coba parse secara otomatis
                    try {
                        $tanggal = \Carbon\Carbon::parse($bm->tanggal_masuk);
                        $tanggalMasukFormatted = $tanggal->format('d-m-Y');
                    } catch (\Exception $e2) {
                        // Jika masih gagal, gunakan nilai asli
                        $tanggalMasukFormatted = $bm->tanggal_masuk;
                        Log::warning('Error parsing tanggal masuk ID ' . $bm->id . ': ' . $e2->getMessage());
                    }
                }
            }

                $rows[] = [
                    $bm->created_at ? $bm->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d-m-Y H:i:s') : '-',
                    $tanggalMasukFormatted,
                    $bm->supplier,
                    $bm->nama_barang,
                    (int)$bm->jumlah_masuk,
                    $bm->satuan,
                    $bm->keterangan ?? '-',
                    $satuanUtama,
                    $faktorKonversi,
                    $jumlahKonversi,
                    $kodeBarang,
                    $status
                ];
            }

            // 3. Update ke Google Sheets
            $sheetName = 'STOK MASUK';
            
            try {
                $sheetInfo = $service->spreadsheets->get($spreadsheetId);
                $sheetExists = false;
                $sheetId = null;
                
                foreach ($sheetInfo->sheets as $sheet) {
                    if ($sheet->properties->title === $sheetName) {
                        $sheetExists = true;
                        $sheetId = $sheet->properties->sheetId;
                        break;
                    }
                }
                
                if ($sheetExists) {
                    // Clear existing data
                    $clearRequest = [
                        'requests' => [
                            [
                                'updateCells' => [
                                    'range' => [
                                        'sheetId' => $sheetId
                                    ],
                                    'fields' => 'userEnteredValue'
                                ]
                            ]
                        ]
                    ];
                    
                    $service->spreadsheets->batchUpdate($spreadsheetId, new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest($clearRequest));
                    
                    // Update with new data
                    $range = $sheetName . '!A1';
                    $body = new \Google_Service_Sheets_ValueRange([
                        'values' => $rows
                    ]);
                    
                    $params = [
                        'valueInputOption' => 'USER_ENTERED'
                    ];
                    
                    $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
                } else {
                    // Create new sheet
                    $requests = [
                        new \Google\Service\Sheets\Request([
                            'addSheet' => [
                                'properties' => [
                                    'title' => $sheetName
                                ]
                            ]
                        ])
                    ];
                    
                    $batchUpdate = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                        'requests' => $requests
                    ]);
                    
                    $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdate);
                    $sheetId = $response->replies[0]->addSheet->properties->sheetId;
                    
                    // Tunggu sebentar
                    sleep(1);
                    
                    // Update data ke sheet baru
                    $range = $sheetName . '!A1';
                    $body = new \Google_Service_Sheets_ValueRange([
                        'values' => $rows
                    ]);
                    
                    $params = [
                        'valueInputOption' => 'USER_ENTERED'
                    ];
                    
                    $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
                }

                // 4. Format spreadsheet (opsional, bisa di-comment jika tidak perlu)
                $this->formatGoogleSheet($service, $spreadsheetId, $sheetId, count($rows[0]), count($rows));

                Log::info('Auto-sync to Google Sheets completed. Total rows: ' . count($rows));
                return true;

            } catch (\Exception $e) {
                Log::error('Auto-sync sheet operation error: ' . $e->getMessage());
                // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Auto-sync to Google Sheets error: ' . $e->getMessage());
            // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
            return false;
        }
    }

    /**
     * Format Google Sheet untuk tampilan yang lebih baik
     */
    private function formatGoogleSheet($service, $spreadsheetId, $sheetId, $colCount, $rowCount)
    {
        try {
            $formatRequests = [
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 0,
                            'endRowIndex' => 1,
                            'startColumnIndex' => 0,
                            'endColumnIndex' => $colCount
                        ],
                        'cell' => [
                            'userEnteredFormat' => [
                                'backgroundColor' => ['red' => 0.2, 'green' => 0.2, 'blue' => 0.6],
                                'textFormat' => ['bold' => true, 'fontSize' => 11, 'foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1]]
                            ]
                        ],
                        'fields' => 'userEnteredFormat(backgroundColor,textFormat)'
                    ]
                ],
                [
                    'updateSheetProperties' => [
                        'properties' => [
                            'sheetId' => $sheetId,
                            'gridProperties' => ['frozenRowCount' => 1]
                        ],
                        'fields' => 'gridProperties.frozenRowCount'
                    ]
                ],
                [
                    'autoResizeDimensions' => [
                        'dimensions' => [
                            'sheetId' => $sheetId,
                            'dimension' => 'COLUMNS',
                            'startIndex' => 0,
                            'endIndex' => $colCount
                        ]
                    ]
                ],
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 4, // Kolom Jumlah Masuk (E)
                            'endColumnIndex' => 5
                        ],
                        'cell' => [
                            'userEnteredFormat' => [
                                'numberFormat' => [
                                    'type' => 'NUMBER',
                                    'pattern' => '#,##0'
                                ]
                            ]
                        ],
                        'fields' => 'userEnteredFormat.numberFormat'
                    ]
                ],
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 8, // Kolom Faktor Konversi (I)
                            'endColumnIndex' => 10 // Kolom Jumlah Konversi (J)
                        ],
                        'cell' => [
                            'userEnteredFormat' => [
                                'numberFormat' => [
                                    'type' => 'NUMBER',
                                    'pattern' => '#,##0.00'
                                ]
                            ]
                        ],
                        'fields' => 'userEnteredFormat.numberFormat'
                    ]
                ],
                // Warna berbeda untuk data di trash
                [
                    'addConditionalFormatRule' => [
                        'rule' => [
                            'ranges' => [
                                [
                                    'sheetId' => $sheetId,
                                    'startRowIndex' => 1,
                                    'endRowIndex' => $rowCount,
                                    'startColumnIndex' => 0,
                                    'endColumnIndex' => $colCount
                                ]
                            ],
                            'booleanRule' => [
                                'condition' => [
                                    'type' => 'TEXT_EQ',
                                    'values' => [
                                        ['userEnteredValue' => 'Trash']
                                    ]
                                ],
                                'format' => [
                                    'backgroundColor' => ['red' => 1, 'green' => 0.9, 'blue' => 0.9],
                                    'textFormat' => [
                                        'strikethrough' => true,
                                        'foregroundColor' => ['red' => 0.6, 'green' => 0.6, 'blue' => 0.6]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $batchFormat = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $formatRequests
            ]);

            $service->spreadsheets->batchUpdate($spreadsheetId, $batchFormat);

            return true;

        } catch (\Exception $e) {
            Log::error('Format Google Sheets error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manual export to Google Sheets (backup function, bisa dihapus atau dipertahankan)
     */
    public function exportToSheets()
    {
        try {
            $result = $this->autoSyncToSheets();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Barang Masuk berhasil disinkronkan ke Google Sheets!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan ke Google Sheets'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Google Sheets export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor ke Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }

}