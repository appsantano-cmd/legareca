<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = ['Bar', 'Kitchen', 'Pastry', 'Server', 'Marcom', 'Cleaning Staff'];

        // Filter data
        $barangKeluars = BarangKeluar::with(['barang', 'satuan'])
            ->filter($request->only(['search', 'department', 'start_date', 'end_date']))
            ->orderBy('tanggal_keluar', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('stock.barangKeluar.index', compact('barangKeluars', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = ['Bar', 'Kitchen', 'Pastry', 'Server', 'Marcom', 'Cleaning Staff'];

        return view('stock.barangKeluar.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Store Barang Keluar - Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'department' => 'required|in:Bar,Kitchen,Pastry,Server,Marcom,Cleaning Staff',
            'barang_id' => 'required|exists:barang,id',
            'jumlah_keluar' => 'required|numeric|min:0.0001',
            'satuan_id' => 'required|exists:satuan,id',
            'keperluan' => 'required|string|max:500',
            'nama_penerima' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Store Barang Keluar - Validation Failed:', $validator->errors()->toArray());

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // 1. Cek stok barang
            $barang = Barang::findOrFail($request->barang_id);
            $satuan = Satuan::findOrFail($request->satuan_id);

            // Konversi jumlah keluar ke satuan utama
            $jumlahDalamSatuanUtama = $request->jumlah_keluar * $satuan->faktor;

            if ($jumlahDalamSatuanUtama > $barang->stok_sekarang) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $barang->stok_sekarang . ' ' . $barang->satuan_utama)
                    ->withInput();
            }

            // 2. Buat transaksi barang keluar
            $barangKeluar = BarangKeluar::create([
                'tanggal_keluar' => $request->tanggal_keluar,
                'department' => $request->department,
                'barang_id' => $request->barang_id,
                'jumlah_keluar' => $request->jumlah_keluar,
                'satuan_id' => $request->satuan_id,
                'keperluan' => $request->keperluan,
                'nama_penerima' => $request->nama_penerima,
            ]);

            // Update stok barang
            $barang->stok_sekarang -= $jumlahDalamSatuanUtama;
            $barang->save();

            DB::commit();

            // Auto-sync to Google Sheets
            $this->autoSyncBarangKeluarToSheets();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Data barang keluar berhasil disimpan! Stok telah diperbarui. Data telah tersinkron ke Google Sheets.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Store Barang Keluar Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'satuan'])->findOrFail($id);

        return view('stock.barangKeluar.show', compact('barangKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $departments = ['Bar', 'Kitchen', 'Pastry', 'Server', 'Marcom', 'Cleaning Staff'];

        return view('stock.barangKeluar.edit', compact('barangKeluar', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'department' => 'required|in:Bar,Kitchen,Pastry,Server,Marcom,Cleaning Staff',
            'keperluan' => 'required|string|max:500',
            'nama_penerima' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $barangKeluar->update([
                'department' => $request->department,
                'keperluan' => $request->keperluan,
                'nama_penerima' => $request->nama_penerima,
            ]);

            DB::commit();

            // Auto-sync to Google Sheets
            $this->autoSyncBarangKeluarToSheets();

            return redirect()->route('barang-keluar.index')
                ->with('success', 'Data barang keluar berhasil diperbarui! Data telah tersinkron ke Google Sheets.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $barangKeluar = BarangKeluar::findOrFail($id);

            // Kembalikan stok barang
            $barang = $barangKeluar->barang;
            $satuan = $barangKeluar->satuan;
            $jumlahDalamSatuanUtama = $barangKeluar->jumlah_keluar * $satuan->faktor;

            $barang->stok_sekarang += $jumlahDalamSatuanUtama;
            $barang->save();

            // Soft delete transaksi
            $barangKeluar->delete();

            DB::commit();

            // Auto-sync to Google Sheets
            $this->autoSyncBarangKeluarToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data barang keluar berhasil dihapus! Stok telah dikembalikan. Data telah tersinkron ke Google Sheets.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get barang list for modal
     */
    public function getBarangList(Request $request)
    {
        $search = $request->get('search', '');

        try {
            $barang = Barang::where('status', true)
                ->where(function ($query) use ($search) {
                    $query->where('nama_barang', 'like', "%{$search}%")
                        ->orWhere('kode_barang', 'like', "%{$search}%");
                })
                ->select('id', 'kode_barang', 'nama_barang', 'satuan_utama', 'stok_sekarang')
                ->orderBy('nama_barang')
                ->limit(50)
                ->get();

            return response()->json($barang);

        } catch (\Exception $e) {
            \Log::error('Error in getBarangList: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get satuan list for modal
     */
    public function getSatuanList(Request $request)
    {
        $search = $request->get('search', '');

        try {
            \Log::info('getSatuanList called', ['search' => $search]);

            $query = Satuan::query();

            // Tambahkan kondisi status=true jika kolom status ada
            if (\Schema::hasColumn('satuan', 'status')) {
                $query->where('status', true);
            }

            // Tambahkan pencarian
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('satuan_input', 'like', "%{$search}%")
                        ->orWhere('satuan_utama', 'like', "%{$search}%");
                });
            }

            $satuan = $query->select('id', 'satuan_input', 'satuan_utama', 'faktor')
                ->orderBy('satuan_input')
                ->limit(50)
                ->get();

            \Log::info('Satuan data found', ['count' => $satuan->count()]);

            return response()->json($satuan);

        } catch (\Exception $e) {
            \Log::error('Error in getSatuanList', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get barang detail
     */
    public function getBarangDetail($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'satuan_utama' => $barang->satuan_utama,
                    'stok_sekarang' => $barang->stok_sekarang,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getBarangDetail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Get satuan detail
     */
    public function getSatuanDetail($id)
    {
        try {
            $satuan = Satuan::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $satuan->id,
                    'satuan_input' => $satuan->satuan_input,
                    'satuan_utama' => $satuan->satuan_utama,
                    'faktor' => $satuan->faktor,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getSatuanDetail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Satuan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show trash page
     */
    public function trash()
    {
        $trashedItems = BarangKeluar::onlyTrashed()
            ->with(['barang', 'satuan'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('stock.barangKeluar.trash', compact('trashedItems'));
    }

    /**
     * Restore soft deleted item
     */
    public function restore($id)
    {
        try {
            DB::beginTransaction();

            $barangKeluar = BarangKeluar::onlyTrashed()->findOrFail($id);

            // Kurangi stok barang saat restore
            $barang = $barangKeluar->barang;
            $satuan = $barangKeluar->satuan;
            $jumlahDalamSatuanUtama = $barangKeluar->jumlah_keluar * $satuan->faktor;

            $barang->stok_sekarang -= $jumlahDalamSatuanUtama;
            $barang->save();

            $barangKeluar->restore();

            DB::commit();

            // Auto-sync to Google Sheets
            $this->autoSyncBarangKeluarToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dipulihkan! Stok telah diperbarui. Data telah tersinkron ke Google Sheets.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force delete item
     */
    public function forceDelete($id)
    {
        try {
            $barangKeluar = BarangKeluar::onlyTrashed()->findOrFail($id);
            $barangKeluar->forceDelete();

            // Auto-sync to Google Sheets
            $this->autoSyncBarangKeluarToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus permanen! Data telah tersinkron ke Google Sheets.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AUTO-SYNC BARANG KELUAR TO GOOGLE SHEETS
     * Method ini dipanggil otomatis setelah setiap operasi CRUD
     */
    private function autoSyncBarangKeluarToSheets()
    {
        try {
            // Cek apakah credentials ada
            $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');
            if (!$credentialsPath || !file_exists($credentialsPath)) {
                \Log::error('Google Sheets credentials not found or invalid');
                return false;
            }

            // Set Google Application Credentials
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . realpath($credentialsPath));

            // Setup Google Client
            $client = new \Google\Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

            $service = new \Google\Service\Sheets($client);
            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

            if (!$spreadsheetId) {
                \Log::error('Google Sheets Spreadsheet ID not configured');
                return false;
            }

            // 1. Ambil data Barang Keluar dengan relasi
            $barangKeluars = BarangKeluar::withTrashed()
                ->with(['barang', 'satuan'])
                ->orderBy('tanggal_keluar', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // 2. Susun array rows sesuai dengan header yang diminta
            $rows = [];
            // Header
            $rows[] = [
                'ID',
                'Tanggal Keluar',
                'Departemen',
                'Nama Barang',
                'Kode Barang',
                'Jumlah Keluar',
                'Satuan Barang',
                'Keperluan',
                'Nama Penerima',
                'Dibuat Pada',
                'Status'
            ];

            foreach ($barangKeluars as $item) {
                // Ambil data barang
                $namaBarang = $item->barang ? $item->barang->nama_barang : '-';
                $kodeBarang = $item->barang ? $item->barang->kode_barang : '-';

                // Ambil data satuan
                $satuanBarang = $item->satuan ? $item->satuan->satuan_input : '-';

                // Tentukan status
                $status = 'Aktif';
                if ($item->trashed()) {
                    $status = 'Trash';
                }

                // Format tanggal keluar
                $tanggalKeluarFormatted = '-';
                if ($item->tanggal_keluar) {
                    try {
                        $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_keluar);
                        $tanggalKeluarFormatted = $tanggal->format('d-m-Y');
                    } catch (\Exception $e) {
                        $tanggalKeluarFormatted = $item->tanggal_keluar;
                    }
                }

                // Format created_at
                $createdAtFormatted = '-';
                if ($item->created_at) {
                    $createdAtFormatted = $item->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s');
                }

                $rows[] = [
                    $item->id,
                    $tanggalKeluarFormatted,
                    $item->department,
                    $namaBarang,
                    $kodeBarang,
                    (float) $item->jumlah_keluar,
                    $satuanBarang,
                    $item->keperluan,
                    $item->nama_penerima,
                    $createdAtFormatted,
                    $status
                ];
            }

            // 3. Update ke Google Sheets
            $sheetName = 'STOK KELUAR';

            try {
                $sheetInfo = $service->spreadsheets->get($spreadsheetId);
                $sheetExists = false;
                $sheetId = null;

                // Cek apakah sheet sudah ada
                foreach ($sheetInfo->sheets as $sheet) {
                    if ($sheet->properties->title === $sheetName) {
                        $sheetExists = true;
                        $sheetId = $sheet->properties->sheetId;
                        break;
                    }
                }

                if ($sheetExists) {
                    // Clear existing data (hanya data, bukan sheet)
                    $range = $sheetName . '!A1:Z1000';
                    $clearBody = new \Google_Service_Sheets_ClearValuesRequest();
                    $service->spreadsheets_values->clear($spreadsheetId, $range, $clearBody);

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

                // 4. Format spreadsheet
                $this->formatBarangKeluarSheet($service, $spreadsheetId, $sheetId, count($rows[0]), count($rows));

                Log::info('Auto-sync Barang Keluar to Google Sheets completed. Total rows: ' . count($rows));
                return true;

            } catch (\Exception $e) {
                Log::error('Auto-sync Barang Keluar sheet operation error: ' . $e->getMessage());
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Auto-sync Barang Keluar to Google Sheets error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format Google Sheet untuk Barang Keluar
     */
    private function formatBarangKeluarSheet($service, $spreadsheetId, $sheetId, $colCount, $rowCount)
    {
        try {
            $formatRequests = [
                // Format header (baris pertama)
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
                                'backgroundColor' => ['red' => 0.2, 'green' => 0.4, 'blue' => 0.6],
                                'textFormat' => [
                                    'bold' => true,
                                    'fontSize' => 11,
                                    'foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1]
                                ]
                            ]
                        ],
                        'fields' => 'userEnteredFormat(backgroundColor,textFormat)'
                    ]
                ],
                // Freeze header row
                [
                    'updateSheetProperties' => [
                        'properties' => [
                            'sheetId' => $sheetId,
                            'gridProperties' => ['frozenRowCount' => 1]
                        ],
                        'fields' => 'gridProperties.frozenRowCount'
                    ]
                ],
                // Auto resize columns
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
                // Format untuk kolom Jumlah Keluar (kolom F, index 5)
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 5,
                            'endColumnIndex' => 6
                        ],
                        'cell' => [
                            'userEnteredFormat' => [
                                'numberFormat' => [
                                    'type' => 'NUMBER',
                                    'pattern' => '#,##0.000'
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
                                    'startColumnIndex' => 10,
                                    'endColumnIndex' => 11
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
                ],
                // Zebra stripes untuk baris data
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
                                    'type' => 'CUSTOM_FORMULA',
                                    'values' => [
                                        ['userEnteredValue' => '=MOD(ROW(),2)=0']
                                    ]
                                ],
                                'format' => [
                                    'backgroundColor' => ['red' => 0.98, 'green' => 0.98, 'blue' => 0.98]
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
            Log::error('Format Barang Keluar Google Sheets error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manual export to Google Sheets (backup function)
     */
    public function exportToSheets()
    {
        try {
            $result = $this->autoSyncBarangKeluarToSheets();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Barang Keluar berhasil disinkronkan ke Google Sheets!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan ke Google Sheets. Cek log untuk detail.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Barang Keluar Google Sheets export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor ke Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }
}