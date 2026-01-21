<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    /**
     * Generate kode barang baru
     */
    public function generateKode(Request $request)
    {
        try {
            $count = $request->input('count', 1);
            $kodeBarang = Barang::generateKodeBarang($count);

            return response()->json([
                'success' => true,
                'kode_barang' => is_array($kodeBarang) ? $kodeBarang[0] : $kodeBarang,
                'kode_list' => $kodeBarang
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua barang aktif (tanpa grouping)
        $barang = Barang::active()
            ->orderBy('nama_barang')
            ->orderBy('kode_barang')
            ->get();

        $trashCount = Barang::onlyTrashed()->count();

        return view('barang.index', compact('barang', 'trashCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodeBarang = Barang::generateKodeBarang();
        return view('barang.create', compact('kodeBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'satuan_utama' => 'required|string|max:50',
            'faktor_konversi' => 'required|numeric|min:0.0001',
            'stok_awal' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $barang = Barang::create([
                'kode_barang' => $request->kode_barang ?? Barang::generateKodeBarang(),
                'nama_barang' => $request->nama_barang,
                'satuan_utama' => $request->satuan_utama,
                'faktor_konversi' => $request->faktor_konversi,
                'stok_awal' => $request->stok_awal,
                'status' => true
                // stok_sekarang akan otomatis diisi = stok_awal dari boot method
            ]);

            DB::commit();

            // Auto-sync to Google Sheets after creating
            $this->autoSyncBarangToSheets();

            return redirect()->route('barang.index')
                ->with('success', 'Data barang berhasil disimpan! Data telah tersinkron ke Google Sheets.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store multiple barang at once
     */
    public function storeMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.satuan_utama' => 'required|string|max:50',
            'items.*.faktor_konversi' => 'required|numeric|min:0.0001',
            'items.*.stok_awal' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $items = $request->items;
            $kodeBarangList = Barang::generateKodeBarang(count($items));
            $createdItems = [];

            foreach ($items as $index => $item) {
                $barang = Barang::create([
                    'kode_barang' => $kodeBarangList[$index],
                    'nama_barang' => $item['nama_barang'],
                    'satuan_utama' => $item['satuan_utama'],
                    'faktor_konversi' => $item['faktor_konversi'],
                    'stok_awal' => $item['stok_awal'],
                    'stok_sekarang' => $item['stok_awal'],
                    'status' => true
                ]);

                $createdItems[] = $barang;
            }

            DB::commit();

            // Auto-sync to Google Sheets after creating multiple items
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => count($createdItems) . ' data barang berhasil disimpan! Data telah tersinkron ke Google Sheets.',
                'data' => $createdItems
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
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Barang::withTrashed()->findOrFail($id);

        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'satuan_utama' => 'required|string|max:50',
            'faktor_konversi' => 'required|numeric|min:0.0001',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'satuan_utama' => $request->satuan_utama,
                'faktor_konversi' => $request->faktor_konversi,
                'status' => $request->status ?? true
            ]);

            // Auto-sync to Google Sheets after update
            $this->autoSyncBarangToSheets();

            return redirect()->route('barang.index')
                ->with('success', 'Data barang berhasil diperbarui! Data telah tersinkron ke Google Sheets.');

        } catch (\Exception $e) {
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
            $barang = Barang::findOrFail($id);
            $barang->delete();

            $trashCount = Barang::onlyTrashed()->count();

            // Auto-sync to Google Sheets after deletion
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data barang berhasil dipindahkan ke trash! Data telah tersinkron ke Google Sheets.',
                'trash_count' => $trashCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore soft deleted barang
     */
    public function restore($id)
    {
        try {
            $barang = Barang::onlyTrashed()->findOrFail($id);
            $barang->restore();

            // Auto-sync to Google Sheets after restore
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data barang berhasil dipulihkan! Data telah tersinkron ke Google Sheets.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force delete barang
     */
    public function forceDelete($id)
    {
        try {
            $barang = Barang::onlyTrashed()->findOrFail($id);
            $barang->forceDelete();

            // Auto-sync to Google Sheets after force delete
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Data barang berhasil dihapus permanen! Data telah tersinkron ke Google Sheets.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore all trashed items
     */
    public function restoreAll()
    {
        try {
            $count = Barang::onlyTrashed()->count();
            Barang::onlyTrashed()->restore();

            // Auto-sync to Google Sheets after restore all
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Semua data berhasil dipulihkan! Data telah tersinkron ke Google Sheets.',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Empty trash
     */
    public function emptyTrash()
    {
        try {
            $count = Barang::onlyTrashed()->count();
            Barang::onlyTrashed()->forceDelete();

            // Auto-sync to Google Sheets after emptying trash
            $this->autoSyncBarangToSheets();

            return response()->json([
                'success' => true,
                'message' => 'Trash berhasil dikosongkan! Data telah tersinkron ke Google Sheets.',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show trash page
     */
    public function trash()
    {
        $trashedItems = Barang::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        $trashCount = Barang::onlyTrashed()->count(); // Tambahkan ini

        return view('barang.trash', compact('trashedItems', 'trashCount')); // Tambahkan trashCount
    }

    /**
     * Get barang list for select2 or datalist
     */
    public function getBarangList()
    {
        $barang = Barang::active()
            ->select('id', 'kode_barang', 'nama_barang', 'satuan_utama', 'stok_sekarang')
            ->orderBy('nama_barang')
            ->get();

        return response()->json($barang);
    }

    /**
     * Check kode barang availability
     */
    public function checkKodeBarang(Request $request)
    {
        $exists = Barang::where('kode_barang', $request->kode_barang)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * AUTO-SYNC BARANG TO GOOGLE SHEETS
     * Method ini dipanggil otomatis setelah setiap operasi CRUD
     */
    private function autoSyncBarangToSheets()
    {
        try {
            // Set Google Application Credentials
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . realpath(env('GOOGLE_APPLICATION_CREDENTIALS')));

            // Setup Google Client
            $client = new \Google\Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

            $service = new \Google\Service\Sheets($client);
            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

            // 1. Ambil data Barang dengan relasi
            $barang = Barang::withTrashed()
                ->orderBy('nama_barang')
                ->orderBy('kode_barang')
                ->get();

            // 2. Susun array rows sesuai dengan header yang diminta
            $rows = [];
            // Header
            $rows[] = [
                'Kode Barang',
                'Nama Barang',
                'Satuan Utama',
                'Faktor Konversi',
                'Stok Awal',
                'Status',
                'Tanggal Dibuat',
                'Tanggal Diperbarui',
                'Tanggal Dihapus'
            ];

            foreach ($barang as $item) {
                // Tentukan status
                $status = 'Aktif';
                if ($item->trashed()) {
                    $status = 'Trash';
                } elseif (!$item->status) {
                    $status = 'Nonaktif';
                }

                $rows[] = [
                    $item->kode_barang,
                    $item->nama_barang,
                    $item->satuan_utama,
                    (float) $item->faktor_konversi,
                    (float) $item->stok_awal,
                    $status,
                    $item->created_at ? $item->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') : '-',
                    $item->updated_at ? $item->updated_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') : '-',
                    $item->deleted_at ? $item->deleted_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') : '-'
                ];
            }

            // 3. Update ke Google Sheets
            $sheetName = 'DATA BARANG';

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

                // 4. Format spreadsheet untuk tampilan yang lebih baik
                $this->formatBarangSheet($service, $spreadsheetId, $sheetId, count($rows[0]), count($rows));

                Log::info('Auto-sync Barang to Google Sheets completed. Total rows: ' . count($rows));
                return true;

            } catch (\Exception $e) {
                Log::error('Auto-sync Barang sheet operation error: ' . $e->getMessage());
                // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Auto-sync Barang to Google Sheets error: ' . $e->getMessage());
            // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
            return false;
        }
    }

    /**
     * Format Google Sheet untuk Daftar Barang
     */
    private function formatBarangSheet($service, $spreadsheetId, $sheetId, $colCount, $rowCount)
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
                                'backgroundColor' => ['red' => 0.2, 'green' => 0.2, 'blue' => 0.6],
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
                // Format untuk kolom Faktor Konversi (kolom D, index 3)
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 3,
                            'endColumnIndex' => 4
                        ],
                        'cell' => [
                            'userEnteredFormat' => [
                                'numberFormat' => [
                                    'type' => 'NUMBER',
                                    'pattern' => '#,##0.0000'
                                ]
                            ]
                        ],
                        'fields' => 'userEnteredFormat.numberFormat'
                    ]
                ],
                // Format untuk kolom Stok Awal dan Stok Sekarang (kolom E dan F, index 4-6)
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 4,
                            'endColumnIndex' => 6
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
                ],
                // Warna berbeda untuk data nonaktif
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
                                        ['userEnteredValue' => 'Nonaktif']
                                    ]
                                ],
                                'format' => [
                                    'backgroundColor' => ['red' => 0.95, 'green' => 0.95, 'blue' => 0.95],
                                    'textFormat' => [
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
            Log::error('Format Barang Google Sheets error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manual export to Google Sheets (backup function)
     */
    public function exportToSheets()
    {
        try {
            $result = $this->autoSyncBarangToSheets();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Barang berhasil disinkronkan ke Google Sheets!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan ke Google Sheets'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Barang Google Sheets export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor ke Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }
}