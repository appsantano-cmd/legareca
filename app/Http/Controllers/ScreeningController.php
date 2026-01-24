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
        \Log::info('=== SUBMIT SCREENING RESULT START ===');
        \Log::info('Full request data:', $request->all());
        \Log::info('Force cancelled:', ['force_cancelled' => $request->input('force_cancelled')]);

        // 1. Ambil data dari request
        $petsData = $request->input('pets', []);

        // 2. Cek apakah ada pet yang memilih "Tidak Jadi Periksa"
        $cancelReasons = [];
        $hasCancelled = false;

        if ($request->has('pets')) {
            \Log::info('Checking for cancelled selections...');
            foreach ($request->pets as $petIndex => $petData) {
                \Log::info("Pet {$petIndex} data:", $petData);

                // Cek kutu
                if (isset($petData['kutu_action']) && $petData['kutu_action'] === 'tidak_periksa') {
                    \Log::info("Pet {$petIndex}: Kutu tidak_periksa found!");
                    $hasCancelled = true;
                    $cancelReasons[] = [
                        'pet_index' => $petIndex,
                        'pet_name' => session('pets')[$petIndex]['name'] ?? 'Anabul ' . ($petIndex + 1),
                        'reason' => 'Kutu positif (' . ($petData['kutu'] ?? 'Positif') . ')'
                    ];
                }

                // Cek birahi
                if (isset($petData['birahi_action']) && $petData['birahi_action'] === 'tidak_periksa') {
                    \Log::info("Pet {$petIndex}: Birahi tidak_periksa found!");
                    $hasCancelled = true;
                    $cancelReasons[] = [
                        'pet_index' => $petIndex,
                        'pet_name' => session('pets')[$petIndex]['name'] ?? 'Anabul ' . ($petIndex + 1),
                        'reason' => 'Birahi positif'
                    ];
                }
            }
        }

        \Log::info('Has cancelled: ' . ($hasCancelled ? 'YES' : 'NO'));

        // ========== CEK APAKAH ADA FORCE CANCELLED ==========
        if ($request->has('force_cancelled') && $request->force_cancelled === 'true') {
            \Log::info('=== FORCE CANCELLED DETECTED ===');

            // Simpan semua data yang ada ke session TANPA NORMALISASI
            // Biarkan data asli dari form
            $screeningData = $request->all();

            \Log::info('Raw screening data for cancelled:', $screeningData);

            // Simpan ke session apa adanya
            session()->put('screening_result', $screeningData);
            session()->put('cancel_reasons', $cancelReasons);

            \Log::info('Session data saved:', [
                'screening_result' => session('screening_result'),
                'cancel_reasons' => session('cancel_reasons'),
                'pets' => session('pets'),
                'owner' => session('owner'),
                'count' => session('count')
            ]);

            // Simpan ke database
            $screening = Screening::saveCancelledData();

            if ($screening) {
                \Log::info('Cancelled data saved successfully! Screening ID: ' . $screening->id);
                session()->put('cancelled_data_saved', true);
                session()->put('screening_id', $screening->id);
            } else {
                \Log::error('Failed to save cancelled data!');
                // Tetap redirect ke cancelled page untuk memberi feedback ke user
            }

            // Redirect ke halaman cancelled
            return redirect()->route('screening.cancelled');
        }

        // 3. Jika ada yang dibatalkan (normal flow - ketika user klik NEXT)
        if ($hasCancelled) {
            \Log::info('=== NORMAL CANCELLED FLOW ===');

            // Simpan data ke session TANPA NORMALISASI
            $screeningData = $request->all();

            \Log::info('Raw screening data for normal cancelled:', $screeningData);

            session()->put('screening_result', $screeningData);
            session()->put('cancel_reasons', $cancelReasons);

            // Simpan ke database
            $screening = Screening::saveCancelledData();

            if (!$screening) {
                \Log::error('Failed to save cancelled data in normal flow');
                return back()->withErrors(['error' => 'Gagal menyimpan data pembatalan']);
            }

            session()->put('cancelled_data_saved', true);
            session()->put('screening_id', $screening->id);

            return redirect()->route('screening.cancelled');
        }

        // 4. Jika TIDAK ada yang dibatalkan, validasi semua field
        // Hanya untuk flow normal, semua field harus diisi (tidak boleh "-")
        $request->validate([
            'pets' => 'required|array|min:1',
            'pets.*.vaksin' => 'required|string|not_in:-',
            'pets.*.kutu' => 'required|string|not_in:-',
            'pets.*.jamur' => 'required|string|not_in:-',
            'pets.*.birahi' => 'required|string|not_in:-',
            'pets.*.kulit' => 'required|string|not_in:-',
            'pets.*.telinga' => 'required|string|not_in:-',
            'pets.*.riwayat' => 'required|string|not_in:-',
        ], [
            'pets.*.vaksin.not_in' => 'Status vaksin harus dipilih',
            'pets.*.kutu.not_in' => 'Hasil pemeriksaan kutu harus dipilih',
            'pets.*.jamur.not_in' => 'Hasil pemeriksaan jamur harus dipilih',
            'pets.*.birahi.not_in' => 'Status birahi harus dipilih',
            'pets.*.kulit.not_in' => 'Hasil pemeriksaan kulit harus dipilih',
            'pets.*.telinga.not_in' => 'Hasil pemeriksaan telinga harus dipilih',
            'pets.*.riwayat.not_in' => 'Riwayat kesehatan harus dipilih',
        ]);

        // 5. Simpan data ke session
        session()->put('screening_result', $request->all());

        // Log data yang akan disimpan
        \Log::info('Screening result for normal flow:', $request->all());

        // 6. Lanjut ke halaman noHp
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
                'pets.*.age_year' => 'required|integer|min:0',
                'pets.*.age_month' => 'required|integer|min:0|max:11',
            ]);

            $pets = [];

            foreach ($request->pets as $pet) {
                $year = (int) $pet['age_year'];
                $month = (int) $pet['age_month'];

                if ($year > 0 && $month > 0) {
                    $ageText = "{$year} Tahun {$month} Bulan";
                } elseif ($year > 0) {
                    $ageText = "{$year} Tahun";
                } else {
                    $ageText = "{$month} Bulan";
                }

                $pets[] = [
                    'name' => $pet['name'],
                    'breed' => $pet['breed'],
                    'sex' => $pet['sex'],
                    'age' => $ageText,
                ];
            }

            session()->put('pets', $pets);

            Log::info('Saved to session:', session('pets'));
            return redirect()->route('screening.result');

        } catch (\Exception $e) {
            Log::error('submitPets error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function cancelled()
    {
        $cancelReasons = session('cancel_reasons', []);
        $screeningId = session('screening_id');

        if (empty($cancelReasons)) {
            return redirect()->route('screening.noHp');
        }

        // Cek apakah data sudah disimpan
        $screening = null;
        if ($screeningId) {
            $screening = Screening::with('pets')->find($screeningId);

            // Jika tidak ditemukan, coba save lagi
            if (!$screening && session('cancelled_data_saved') !== true) {
                $screening = Screening::saveCancelledData();
            }
        }

        // Jika masih tidak ada, coba save
        if (!$screening) {
            $screening = Screening::saveCancelledData();
        }

        // Ekspor ke Google Sheets
        if ($screening) {
            $this->exportToSheets();

            // Kirim email notifikasi
            $this->sendCancelledEmailNotification($cancelReasons);

            // Clear session flag
            session()->forget(['cancelled_data_saved', 'screening_id']);
        }

        return view('screening.cancelled', [
            'reasons' => $cancelReasons,
            'owner' => session('owner', 'Owner'),
            'pets' => session('pets', []),
            'screening' => $screening
        ]);
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

            if (!$screening) {
                throw new \Exception('Gagal menyimpan data screening');
            }

            // Ambil data dari DB untuk email
            $screening = Screening::with('pets')->find($screening->id);

            // Kirim email notifikasi
            $this->sendEmailNotification($screening);

            return redirect()->route('screening.thankyou');

        } catch (\Exception $e) {
            Log::error('submitNoHp error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
        }
    }

    private function sendCancelledEmailNotification($cancelReasons)
    {
        try {
            $ownerEmail = "appsantano@gmail.com";
            $owner = session('owner', 'Tidak diketahui');
            $pets = session('pets', []);
            $screeningData = session('screening_result', []);

            $body = "⚠️ SCREENING DIBATALKAN — Le Gareca Space ⚠️\n\n";
            $body .= "Ada screening yang dibatalkan dengan detail berikut:\n\n";
            $body .= "👤 Owner: " . $owner . "\n";
            $body .= "🐶 Total Pet: " . count($pets) . "\n";
            $body .= "⏰ Waktu: " . now()->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s') . "\n\n";

            $body .= "ALASAN PEMBATALAN:\n";
            foreach ($cancelReasons as $reason) {
                $body .= "• " . $reason['pet_name'] . ": " . $reason['reason'] . "\n";
            }

            $body .= "\nDETAIL SCREENING YANG TERSIMPAN:\n";
            $body .= "=====================================\n\n";

            if (isset($screeningData['pets'])) {
                foreach ($screeningData['pets'] as $index => $petData) {
                    if (isset($pets[$index])) {
                        $body .= "🐾 Pet #" . ($index + 1) . ": " . ($pets[$index]['name'] ?? 'Anabul ' . ($index + 1)) . "\n";
                        $body .= "  Vaksin: " . ($petData['vaksin'] ?? '-') . "\n";
                        $body .= "  Kutu: " . ($petData['kutu'] ?? '-') . " " . (isset($petData['kutu_action']) ? "[" . ($petData['kutu_action'] == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') . "]" : "") . "\n";
                        $body .= "  Jamur: " . ($petData['jamur'] ?? '-') . "\n";
                        $body .= "  Birahi: " . ($petData['birahi'] ?? '-') . " " . (isset($petData['birahi_action']) ? "[" . ($petData['birahi_action'] == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') . "]" : "") . "\n";
                        $body .= "  Kulit: " . ($petData['kulit'] ?? '-') . "\n";
                        $body .= "  Telinga: " . ($petData['telinga'] ?? '-') . "\n";
                        $body .= "  Riwayat: " . ($petData['riwayat'] ?? '-') . "\n";
                        $body .= "  ------------------------\n\n";
                    }
                }
            }

            $body .= "Data ini telah tersimpan di database dan Google Sheets.\n\n";
            $body .= "Mohon tindak lanjut sesuai SOP internal.\n\n";
            $body .= "Terima kasih.\n\n";
            $body .= "— Sistem Screening Le Gareca";

            Mail::raw($body, function ($message) use ($ownerEmail) {
                $message->to($ownerEmail)
                    ->subject("⚠️ Screening Dibatalkan — Le Gareca Space");
            });

        } catch (\Exception $e) {
            Log::error('Failed to send cancelled email: ' . $e->getMessage());
        }
    }

    private function sendEmailNotification($screening)
    {
        try {
            $ownerEmail = "appsantano@gmail.com";

            $body = "✅ SCREENING BARU — Le Gareca Space ✅\n\n";
            $body .= "Ada input screening baru dari sistem dengan detail berikut:\n\n";
            $body .= "👤 Owner: " . $screening->owner_name . "\n";
            $body .= "📱 Phone: " . $screening->phone_number . "\n";
            $body .= "🐶 Total Pet: " . $screening->pet_count . "\n";
            $body .= "⏰ Waktu Input: " . $screening->created_at->setTimezone('Asia/Jakarta')->translatedFormat('j F Y H:i:s') . "\n";
            $body .= "📊 Status: " . ($screening->status == 'cancelled' ? 'Dibatalkan' : 'Selesai') . "\n\n";

            foreach ($screening->pets as $index => $pet) {
                $body .= "🐾 Pet #" . ($index + 1) . "\n";
                $body .= "  Nama: " . $pet->name . "\n";
                $body .= "  Breed: " . $pet->breed . "\n";
                $body .= "  Sex: " . $pet->sex . "\n";
                $body .= "  Age: " . $pet->age . "\n";
                $body .= "  Vaksin: " . $pet->vaksin . "\n";
                $body .= "  Kutu: " . $pet->kutu . " " . ($pet->kutu_action ? "[" . ($pet->kutu_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') . "]" : "") . "\n";
                $body .= "  Jamur: " . $pet->jamur . "\n";
                $body .= "  Birahi: " . $pet->birahi . " " . ($pet->birahi_action ? "[" . ($pet->birahi_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') . "]" : "") . "\n";
                $body .= "  Kulit: " . $pet->kulit . "\n";
                $body .= "  Telinga: " . $pet->telinga . "\n";
                $body .= "  Riwayat: " . $pet->riwayat . "\n";
                $body .= "  Status: " . $pet->status_text . "\n";
                $body .= "  ------------------------\n\n";
            }

            $body .= "Mohon tindak lanjut sesuai SOP internal.\n\n";
            $body .= "Terima kasih.\n\n";
            $body .= "— Sistem Screening Le Gareca";

            Mail::raw($body, function ($message) use ($ownerEmail, $screening) {
                $subject = $screening->status == 'cancelled'
                    ? "⚠️ Screening Dibatalkan — Le Gareca"
                    : "✅ Screening Baru — Le Gareca";

                $message->to($ownerEmail)
                    ->subject($subject);
            });

        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
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
        try {
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . realpath(env('GOOGLE_APPLICATION_CREDENTIALS')));

            $client = new \Google\Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

            $service = new \Google\Service\Sheets($client);
            Sheets::setService($service);

            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

            // 1. Ambil data dari DB (termasuk yang cancelled)
            $screenings = Screening::with('pets')->get();

            // 2. Susun array rows
            $rows = [];
            $rows[] = [
                'ID',
                'Status',
                'Tanggal',
                'Owner',
                'Jumlah Pet',
                'Phone',
                'Pet Name',
                'Breed',
                'Sex',
                'Age',
                'Vaksin',
                'Kutu',
                'Kutu Action',
                'Jamur',
                'Birahi',
                'Birahi Action',
                'Kulit',
                'Telinga',
                'Riwayat',
                'Pet Status'
            ];

            foreach ($screenings as $s) {
                foreach ($s->pets as $p) {
                    $rows[] = [
                        $s->id,
                        $s->status_text,
                        $s->created_at->setTimezone('Asia/Jakarta')->translatedFormat('Y-m-d H:i:s'),
                        $s->owner_name,
                        $s->pet_count,
                        $s->phone_number,
                        $p->name,
                        $p->breed,
                        $p->sex,
                        $p->age,
                        $p->vaksin,
                        $p->kutu,
                        $p->kutu_action ? ($p->kutu_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') : '-',
                        $p->jamur,
                        $p->birahi,
                        $p->birahi_action ? ($p->birahi_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') : '-',
                        $p->kulit,
                        $p->telinga,
                        $p->riwayat,
                        $p->status_text
                    ];
                }
            }

            // 3. Update ke Google Sheets
            Sheets::spreadsheet($spreadsheetId)->sheet('Screening')->clear();
            Sheets::spreadsheet($spreadsheetId)->sheet('Screening')->range('A1')->update($rows);

            // 4. Format spreadsheet
            $sheetInfo = $service->spreadsheets->get($spreadsheetId);
            $sheetId = $sheetInfo->sheets[0]->properties->sheetId;

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
                                'backgroundColor' => ['red' => 0.95, 'green' => 0.95, 'blue' => 0.95],
                                'textFormat' => ['bold' => true, 'fontSize' => 11]
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

            Log::info('Google Sheets export completed successfully');

            // Kembalikan response JSON untuk fetch
            return response()->json([
                'success' => true,
                'message' => 'Data exported to Google Sheets successfully',
                'count' => $screenings->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Google Sheets export error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }
}