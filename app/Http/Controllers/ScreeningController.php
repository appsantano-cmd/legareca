<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Mail;

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

    public function yakin()
    {
        return view('screening.yakin');
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
            return back()->withErrors(['no_hp' => 'Format nomor telepon tidak valid']);
        }

        // Simpan ke database
        try {
            $screening = Screening::saveFromSession();

            // Ambil data dari DB untuk email
            $screening = Screening::with('pets')->find($screening->id);

            // --- SEND EMAIL NOTIFICATION TO OWNER ---
            $ownerEmail = "appsantano@gmail.com"; // Email yang menerima hasil input

            $body = "Halo Owner,\n\n";
            $body .= "Ada input screening baru dari sistem dengan detail berikut:\n\n";
            $body .= "👤 Owner: " . $screening->owner_name . "\n";
            $body .= "📱 Phone: " . $screening->phone_number . "\n";
            $body .= "🐶 Total Pet: " . $screening->pet_count . "\n";
            $body .= "⏰ Waktu Input: " . $screening->created_at->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s') . "\n\n";

            foreach ($screening->pets as $index => $pet) {
                $body .= "🐾 Pet #" . ($index + 1) . "\n";
                $body .= "Nama: " . $pet->name . "\n";
                $body .= "Breed: " . $pet->breed . "\n";
                $body .= "Sex: " . $pet->sex . "\n";
                $body .= "Age: " . $pet->age . "\n";
                $body .= "Vaksin: " . $pet->vaksin . "\n";
                $body .= "Kutu: " . $pet->kutu . "\n";
                $body .= "Jamur: " . $pet->jamur . "\n";
                $body .= "Birahi: " . $pet->birahi . "\n";
                $body .= "Kulit: " . $pet->kulit . "\n";
                $body .= "Telinga: " . $pet->telinga . "\n";
                $body .= "Riwayat: " . $pet->riwayat . "\n";
                $body .= "------------------------\n\n";
            }

            $body .= "Mohon tindak lanjut sesuai SOP internal.\n\n";
            $body .= "Terima kasih.\n\n";
            $body .= "— Sistem Screening Le Gareca";

            Mail::raw($body, function ($message) use ($ownerEmail) {
                $message->to($ownerEmail)
                    ->subject("Notifikasi Screening Baru — Le Gareca");
            });
            // --- END EMAIL ---

            return redirect()->route('screening.thankyou');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
        }
    }

    public function thankyou()
    {
        // auto export saat halaman thankyou dibuka
        $this->exportToSheets();
        return view('screening.thankyou');
    }

    public function exportToSheets()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . realpath(env('GOOGLE_APPLICATION_CREDENTIALS')));

        $client = new \Google\Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

        $service = new \Google\Service\Sheets($client);
        Sheets::setService($service);

        $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

        // 1. Ambil data dari DB
        $screenings = Screening::with('pets')->get();

        // 2. Susun array rows
        $rows = [];
        $rows[] = ['Created At', 'Owner', 'Pet Count', 'Phone', 'Pet Name', 'Breed', 'Sex', 'Age', 'Vaksin', 'Kutu', 'Jamur', 'Birahi', 'Kulit', 'Telinga', 'Riwayat'];

        foreach ($screenings as $s) {
            foreach ($s->pets as $p) {
                $rows[] = [
                    $s->created_at->timestamp, // simpan timestamp untuk sorting
                    $s->created_at->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s'),
                    $s->owner_name,
                    $s->pet_count,
                    $s->phone_number,
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

        // 3. Sorting data (skip header)
        $header = $rows[0];
        $data = array_slice($rows, 1);

        usort($data, function ($a, $b) {
            return $a[0] <=> $b[0] ?: strcmp($a[2], $b[2]); // sort by timestamp, lalu owner name
        });

        // Hapus kolom timestamp setelah sorting
        $data = array_map(fn($row) => array_slice($row, 1), $data);

        $rows = array_merge([$header], $data);

        // 4. Update ke Google Sheets
        Sheets::spreadsheet($spreadsheetId)->sheet('Screening')->clear();
        Sheets::spreadsheet($spreadsheetId)->sheet('Screening')->range('A1')->update($rows);

        // 5. Ambil sheetId asli
        $sheetInfo = $service->spreadsheets->get($spreadsheetId);
        $sheetId = $sheetInfo->sheets[0]->properties->sheetId;

        // 6. Format header: bold, freeze, autosize
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

        $batchFormat = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $formatRequests
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchFormat);

        return true;
    }

}
