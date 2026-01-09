<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Screening;
use App\Models\ScreeningPet;

class ScreeningController extends Controller
{
    public function welcome()
    {
        return view('screening.welcome');
    }

    public function agreement()
    {
        return view('screening.agreement');
    }

    public function ownerForm()
    {
        return view('screening.owner-form');
    }

    public function submitOwner(Request $request)
    {
        $request->validate([
            'owner' => 'required|string|max:100',
            'count' => 'required|integer|min:1|max:10'
        ]);

        session()->put('owner', $request->owner);
        session()->put('count', $request->count);

        return redirect()->route('screening.petTable', ['count' => $request->count]);
    }

    public function petTable(Request $request)
    {
        $count = $request->query('count', session('count', 1));
        return view('screening.pet-table', ['count' => $count]);
    }

    public function screeningResult()
    {
        return view('screening.screening-form', [
            'pets' => session('pets', [])
        ]);
    }

    public function submitScreeningResult(Request $request)
    {
        $request->validate([
            'pets' => 'required|array|min:1',
            'pets.*.vaksin' => 'required|string',
            'pets.*.kutu' => 'required|string',
            'pets.*.jamur' => 'required|string',
            'pets.*.birahi' => 'required|string',
            'pets.*.kulit' => 'required|string',
            'pets.*.telinga' => 'required|string',
            'pets.*.riwayat' => 'required|string',
        ]);

        session()->put('screening_result', $request->pets);

        return redirect()->route('screening.noHp');
    }

    public function submitPets(Request $request)
    {
        Log::info('=== SUBMIT PETS START ===');
        Log::info('Request:', $request->all());

        try {
            $request->validate([
                'pets' => 'required|array|min:1',
                'pets.*.name' => 'required|string|max:100',
                'pets.*.breed' => 'required|string|max:100',
                'pets.*.sex' => 'required|string|max:20',
                'pets.*.age' => 'required|string|max:20',
            ]);

            session()->put('pets', $request->pets);

            Log::info('Saved to session:', session('pets'));
            return redirect()->route('screening.result');

        } catch (\Exception $e) {
            Log::error('submitPets error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function noHp()
    {
        return view('screening.noHp');
    }

    public function submitNoHp(Request $request)
    {
        $request->validate([
            'no_hp' => 'required|numeric|max_digits:13'
        ]);

        session()->put('no_hp', $request->no_hp);
        session()->put('country_code', $request->country_code ?? '+62');

        // Validasi format nomor telepon sebelum simpan
        $fullPhoneNumber = Screening::formatPhoneNumber(
            session('country_code', '+62'),
            session('no_hp')
        );

        if (!Screening::validatePhoneNumber($fullPhoneNumber)) {
            Log::error('Invalid phone number format', [
                'country_code' => session('country_code'),
                'phone' => session('no_hp'),
                'formatted' => $fullPhoneNumber
            ]);

            return back()->withErrors([
                'no_hp' => 'Format nomor telepon tidak valid. Pastikan nomor benar.'
            ]);
        }

        // Simpan ke database
        try {
            $screening = Screening::saveFromSession();

            if (!$screening) {
                Log::error('Failed to save screening to database');
                return back()->withErrors(['error' => 'Gagal menyimpan data screening. Silakan coba lagi.']);
            }

            Log::info('Screening saved successfully', [
                'id' => $screening->id,
                'owner' => $screening->owner_name,
                'phone' => $screening->phone_number,
                'formatted' => $screening->formatted_phone
            ]);

            return redirect()->route('screening.thankyou');

        } catch (\Exception $e) {
            Log::error('Error saving screening: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function thankyou()
    {
        return view('screening.thankyou');
    }

    public function yakin()
    {
        return view('screening.yakin');
    }

    public function exportToSheets()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . env('GOOGLE_APPLICATION_CREDENTIALS'));

        $client = new \Google\Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

        $service = new \Google\Service\Sheets($client);
        Sheets::setService($service);

        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $sheetId = 0; // sheet pertama

        // 1. Ambil data dari DB
        $screenings = Screening::with('pets')->get();

        // 2. Susun array rows
        $rows = [];
        $rows[] = ['Created At', 'Owner', 'Pet Count', 'Phone', 'Status', 'Pet Name', 'Breed', 'Sex', 'Age', 'Vaksin', 'Kutu', 'Jamur', 'Birahi', 'Kulit', 'Telinga', 'Riwayat'];

        foreach ($screenings as $s) {
            foreach ($s->pets as $p) {
                $rows[] = [
                    $s->created_at->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s'),
                    $s->owner_name,
                    $s->pet_count,
                    $s->phone_number,
                    $s->status,
                    $p->name,
                    $p->breed,
                    $p->sex,
                    $p->age,
                    $p->vaksin,
                    $p->kutu,
                    $p->jamur,
                    $p->birahi,
                    $p->kulit,
                    $p->telinga,
                    $p->riwayat,
                ];
            }
        }

        // 3. Sort dulu sebelum dikirim ke Google Sheets
        $header = $rows[0];
        $data = array_slice($rows, 1);

        usort($data, function ($a, $b) {
            return strtotime($a[0]) <=> strtotime($b[0]) ?: strcmp($a[1], $b[1]);
        });

        $rows = array_merge([$header], $data);

        // 4. Baru update ke Google Sheets
        Sheets::spreadsheet($spreadsheetId)->sheet('Sheet1')->clear();
        Sheets::spreadsheet($spreadsheetId)->sheet('Sheet1')->range('A1')->update($rows);

        // 5. Ambil sheetId asli
        $sheetInfo = $service->spreadsheets->get($spreadsheetId);
        $sheetId = $sheetInfo->sheets[0]->properties->sheetId;

        // 6. Merge cell jika Created At & Owner sama berurutan
        $mergeRequests = [];
        $start = 1;

        while ($start < count($rows)) {
            $currentDate = $rows[$start][0];
            $currentOwner = $rows[$start][1];

            $end = $start + 1;
            while ($end < count($rows) && $rows[$end][0] === $currentDate && $rows[$end][1] === $currentOwner) {
                $end++;
            }

            if ($end - $start > 1) {
                $mergeRequests[] = [
                    'mergeCells' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => $start,
                            'endRowIndex' => $end,
                            'startColumnIndex' => 0,
                            'endColumnIndex' => 1,
                        ],
                        'mergeType' => 'MERGE_ROWS'
                    ]
                ];

                $mergeRequests[] = [
                    'mergeCells' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => $start,
                            'endRowIndex' => $end,
                            'startColumnIndex' => 1,
                            'endColumnIndex' => 2,
                        ],
                        'mergeType' => 'MERGE_ROWS'
                    ]
                ];
            }

            $start = $end;
        }

        // 7. Kirim request merge ke API
        if (!empty($mergeRequests)) {
            $batchMerge = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $mergeRequests
            ]);
            $service->spreadsheets->batchUpdate($spreadsheetId, $batchMerge);
        }

        // 8. Set header bold, freeze, autosize kolom
        $formatRequests = [
            [
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0,
                        'endRowIndex' => 1,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => count($rows[0])
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'backgroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1],
                            'textFormat' => ['bold' => true, 'fontSize' => 12]
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
                        'endIndex' => count($rows[0])
                    ]
                ]
            ]
        ];

        // 9. Kirim format header ke API
        $batchFormat = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $formatRequests
        ]);
        $service->spreadsheets->batchUpdate($spreadsheetId, $batchFormat);

        return redirect("https://docs.google.com/spreadsheets/d/$spreadsheetId");
    }

}
