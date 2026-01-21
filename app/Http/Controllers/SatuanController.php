<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SatuanController extends Controller
{
    /**
     * API untuk mendapatkan list satuan (untuk modal)
     */
    public function apiIndex()
    {
        try {
            $satuans = Satuan::select('id', 'satuan_utama', 'satuan_input', 'faktor')
                ->orderBy('satuan_utama')
                ->get();

            return response()->json($satuans);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data satuan',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuans = Satuan::orderBy('satuan_utama')->get();
        return view('barang.satuan', compact('satuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Form akan ditampilkan di view yang sama
        return view('barang.satuan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'satuan_input' => 'required|string|max:50',
            'satuan_utama' => 'required|string|max:50',
            'faktor' => 'required|numeric|min:0.0001|max:99999999.99999',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Satuan::create($request->all());

        // Auto-sync to Google Sheets after creating
        $this->autoSyncSatuanToSheets();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan! Data telah tersinkron ke Google Sheets.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        return view('barang.satuan-show', compact('satuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        $satuans = Satuan::orderBy('satuan_utama')->get();
        return view('barang.satuan', compact('satuan', 'satuans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $validator = Validator::make($request->all(), [
            'satuan_input' => 'required|string|max:50',
            'satuan_utama' => 'required|string|max:50',
            'faktor' => 'required|numeric|min:0.0001|max:99999999.99999',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $satuan->update($request->all());

        // Auto-sync to Google Sheets after updating
        $this->autoSyncSatuanToSheets();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui! Data telah tersinkron ke Google Sheets.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        // Auto-sync to Google Sheets after deleting
        $this->autoSyncSatuanToSheets();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus! Data telah tersinkron ke Google Sheets.');
    }

    /**
     * AUTO-SYNC SATUAN TO GOOGLE SHEETS
     * Method ini dipanggil otomatis setelah setiap operasi CRUD
     */
    private function autoSyncSatuanToSheets()
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

            // 1. Ambil data Satuan - DIUBAH: Urutkan berdasarkan ID terkecil
            $satuans = Satuan::orderBy('id', 'asc')
                ->orderBy('satuan_utama')
                ->orderBy('satuan_input')
                ->get();

            // 2. Susun array rows sesuai dengan header yang diminta
            $rows = [];
            // Header
            $rows[] = [
                'Satuan Input',
                'Satuan Utama',
                'Faktor',
                'Tanggal Dibuat',
                'Tanggal Diperbarui'
            ];

            foreach ($satuans as $item) {
                $rows[] = [
                    $item->satuan_input,
                    $item->satuan_utama,
                    (float) $item->faktor,
                    $item->created_at ? $item->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') : '-',
                    $item->updated_at ? $item->updated_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') : '-'
                ];
            }

            // 3. Update ke Google Sheets
            $sheetName = 'KONVERSI SATUAN';
            
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

                // 4. Format spreadsheet untuk tampilan yang lebih baik - TAMBAHKAN SORTING
                $this->formatSatuanSheet($service, $spreadsheetId, $sheetId, count($rows[0]), count($rows));

                Log::info('Auto-sync Satuan to Google Sheets completed. Total rows: ' . count($rows));
                return true;

            } catch (\Exception $e) {
                Log::error('Auto-sync Satuan sheet operation error: ' . $e->getMessage());
                // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Auto-sync Satuan to Google Sheets error: ' . $e->getMessage());
            // Jangan throw exception di auto-sync agar tidak mengganggu operasi utama
            return false;
        }
    }

    /**
     * Format Google Sheet untuk Konversi Satuan
     */
    private function formatSatuanSheet($service, $spreadsheetId, $sheetId, $colCount, $rowCount)
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
                                'backgroundColor' => ['red' => 0.2, 'green' => 0.5, 'blue' => 0.2], // Warna hijau
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
                // Format untuk kolom Faktor (kolom C, index 2)
                [
                    'repeatCell' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1,
                            'startColumnIndex' => 2,
                            'endColumnIndex' => 3
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
                // Format untuk kolom ID (kolom D, index 3)
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
                                    'pattern' => '0'
                                ]
                            ]
                        ],
                        'fields' => 'userEnteredFormat.numberFormat'
                    ]
                ],
                // TAMBAHKAN SORTING: Sort by ID column (kolom D) secara otomatis
                [
                    'sortRange' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 1, // Mulai dari baris 2 (setelah header)
                            'endRowIndex' => $rowCount,
                            'startColumnIndex' => 0,
                            'endColumnIndex' => $colCount
                        ],
                        'sortSpecs' => [
                            [
                                'dimensionIndex' => 3, // Kolom D (ID) - index 3
                                'sortOrder' => 'ASCENDING' // Urutkan naik (kecil ke besar)
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
            Log::error('Format Satuan Google Sheets error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manual export to Google Sheets (backup function)
     */
    public function exportToSheets()
    {
        try {
            $result = $this->autoSyncSatuanToSheets();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Satuan berhasil disinkronkan ke Google Sheets!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan ke Google Sheets'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Satuan Google Sheets export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekspor ke Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }
}