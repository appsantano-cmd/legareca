<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Mail;
use App\Exports\ScreeningsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\GoogleSheetsService;

use App\Models\Screening;
use App\Models\ScreeningPet;
use App\Mail\ScreeningCompleted;
use App\Mail\ScreeningCancelled;

class ScreeningController extends Controller
{

    /**
     * Display a listing of the screenings.
     */
    public function index(Request $request)
    {
        // Filter parameters
        $search = $request->query('search');
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Base query
        $query = Screening::with('pets')->latest();

        // Apply filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('owner_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhereHas('pets', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Get paginated results
        $screenings = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => Screening::count(),
            'completed' => Screening::where('status', 'completed')->count(),
            'cancelled' => Screening::where('status', 'cancelled')->count(),
            'today' => Screening::whereDate('created_at', today())->count(),
        ];

        return view('screening.index', compact('screenings', 'stats', 'search', 'status', 'startDate', 'endDate'));
    }

    /**
     * Display the specified screening.
     */
    public function show($id)
    {
        $screening = Screening::with('pets')->findOrFail($id);
        return view('screening.show', compact('screening'));
    }

    /**
     * Remove the specified screening from storage.
     */
    public function destroy($id)
    {
        try {
            $screening = Screening::findOrFail($id);
            $screening->pets()->delete();
            $screening->delete();

            return redirect()->route('screening.index')
                ->with('success', 'Data screening berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Failed to delete screening: ' . $e->getMessage());
            return redirect()->route('screening.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

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

        // 1. Validasi semua field untuk flow normal
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

        // 2. Deteksi kondisi untuk menentukan status
        $hasCancelledPet = false;
        $cancelReasons = [];
        $kutuPositifNeedsAction = [];

        if ($request->has('pets')) {
            \Log::info('Checking for cancelled conditions...');
            foreach ($request->pets as $petIndex => $petData) {
                \Log::info("Pet {$petIndex} data:", $petData);

                $petCancelled = false;
                $reason = '';

                // Cek kutu positif yang membutuhkan action
                if (isset($petData['kutu']) && $petData['kutu'] === 'Positif') {
                    if (!isset($petData['kutu_action']) || $petData['kutu_action'] === '') {
                        $kutuPositifNeedsAction[] = $petIndex;
                        continue; // Skip validasi lainnya untuk pet ini
                    }

                    // Jika sudah memilih action, cek pilihannya
                    if (isset($petData['kutu_action']) && $petData['kutu_action'] === 'tidak_periksa') {
                        $petCancelled = true;
                        $hasCancelledPet = true;
                        $reason = 'Kutu positif (tidak jadi periksa)';
                    }
                    // Jika memilih lanjut_obat, tidak cancelled (status completed)
                }

                // Aturan 2: Kutu Positif 2 atau Positif 3 -> cancelled
                if (isset($petData['kutu']) && in_array($petData['kutu'], ['Positif 2', 'Positif 3'])) {
                    $petCancelled = true;
                    $hasCancelledPet = true;
                    $reason = 'Kutu ' . $petData['kutu'];
                }

                // Aturan 3: Birahi Positif -> cancelled
                if (isset($petData['birahi']) && $petData['birahi'] === 'Positif') {
                    $petCancelled = true;
                    $hasCancelledPet = true;
                    $reason = 'Birahi positif';
                }

                // Aturan 3a: Birahi Positif dengan pilihan tidak_periksa -> cancelled
                if (isset($petData['birahi_action']) && $petData['birahi_action'] === 'tidak_periksa') {
                    $petCancelled = true;
                    $hasCancelledPet = true;
                    $reason = 'Birahi positif (tidak jadi periksa)';
                }

                if ($petCancelled) {
                    $cancelReasons[] = [
                        'pet_index' => $petIndex,
                        'pet_name' => session('pets')[$petIndex]['name'] ?? 'Anabul ' . ($petIndex + 1),
                        'reason' => $reason
                    ];
                }
            }
        }

        // Validasi tambahan untuk kutu positif yang belum pilih action
        if (!empty($kutuPositifNeedsAction)) {
            \Log::warning('Kutu positif needs action:', $kutuPositifNeedsAction);

            $errorMessages = [];
            foreach ($kutuPositifNeedsAction as $petIndex) {
                $petName = session('pets')[$petIndex]['name'] ?? 'Anabul ' . ($petIndex + 1);
                $errorMessages["pets.{$petIndex}.kutu_action"] = "Silakan pilih tindakan untuk kutu positif pada {$petName}";
            }

            return back()
                ->withErrors($errorMessages)
                ->withInput();
        }

        \Log::info('Cancelled pets found:', $cancelReasons);
        \Log::info('Has cancelled pet: ' . ($hasCancelledPet ? 'YES' : 'NO'));

        // 3. Simpan data ke session (termasuk cancel reasons)
        $screeningData = $request->all();
        session()->put('screening_result', $screeningData);
        session()->put('cancel_reasons', $cancelReasons);
        session()->put('has_cancelled_pet', $hasCancelledPet);

        // 4. Lanjut ke halaman noHp
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

            // Simpan screening_id ke session untuk review data
            session()->put('screening_id', $screening->id);

            // Ambil data dari DB untuk email
            $screening = Screening::with('pets')->find($screening->id);

            // Kirim email notifikasi ke Santano
            $this->sendEmailNotification($screening);

            // Ekspor ke Google Sheets
            $this->exportToSheets();

            // Redirect ke review data
            return redirect()->route('screening.thankyou');

        } catch (\Exception $e) {
            Log::error('submitNoHp error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
        }
    }

    public function thankyou()
    {
        return view('screening.thankyou');
    }

    public function reviewData()
    {
        try {
            // Cek apakah ada screening_id di session
            $screeningId = session('screening_id');

            if (!$screeningId) {
                \Log::warning('No screening_id in session. Current session:', [
                    'screening_id' => session('screening_id'),
                    'owner' => session('owner'),
                    'has_no_hp' => session()->has('no_hp')
                ]);

                // Jika user baru saja submit dari thankyou page, coba ambil screening terakhir
                $screening = Screening::with('pets')
                    ->where('owner_name', session('owner'))
                    ->when(session('no_hp'), function ($query) {
                        return $query->where('phone_number', session('no_hp'));
                    })
                    ->latest()
                    ->first();

                if ($screening) {
                    // Simpan screening_id ke session untuk next time
                    session()->put('screening_id', $screening->id);
                }
            } else {
                $screening = Screening::with('pets')->find($screeningId);
            }

            if (!$screening) {
                \Log::error('Screening not found. ID: ' . $screeningId);
                return redirect()->route('screening.thankyou')
                    ->with('error', 'Data screening tidak ditemukan. Silakan lakukan screening baru.');
            }

            // Ambil restricted pets langsung dari database
            $restrictedPets = [];

            foreach ($screening->pets as $index => $pet) {
                // Tentukan apakah pet ini tidak boleh masuk berdasarkan data di database
                $isRestricted = false;
                $restrictionReasons = [];

                // Aturan 1: Kutu Positif dengan action tidak_periksa
                if ($pet->kutu === 'Positif' && $pet->kutu_action === 'tidak_periksa') {
                    $isRestricted = true;
                    $restrictionReasons[] = 'Kutu positif (tidak jadi periksa)';
                }

                // Aturan 2: Kutu Positif 2 atau Positif 3
                if (in_array($pet->kutu, ['Positif 2', 'Positif 3'])) {
                    $isRestricted = true;
                    $restrictionReasons[] = 'Kutu ' . $pet->kutu;
                }

                // Aturan 3: Birahi Positif
                if ($pet->birahi === 'Positif') {
                    $isRestricted = true;
                    $restrictionReasons[] = 'Birahi positif';
                }

                // Aturan 4: Birahi Positif dengan action tidak_periksa
                if ($pet->birahi === 'Positif' && $pet->birahi_action === 'tidak_periksa') {
                    $isRestricted = true;
                    $restrictionReasons[] = 'Birahi positif (tidak jadi periksa)';
                }

                if ($isRestricted) {
                    $restrictedPets[] = [
                        'pet_index' => $index,
                        'pet_name' => $pet->name,
                        'reasons' => $restrictionReasons
                    ];
                }
            }

            return view('screening.review-data', compact('screening', 'restrictedPets'));

        } catch (\Exception $e) {
            Log::error('Review data error: ' . $e->getMessage());
            return redirect()->route('screening.thankyou')
                ->with('error', 'Terjadi kesalahan saat memuat data review: ' . $e->getMessage());
        }
    }

    /**
     * Export data to Spreadsheet using GoogleSheetsService
     */
    public function exportToSheets()
    {
        try {
            // 1. Inisialisasi GoogleSheetsService
            $sheetsService = new \App\Services\GoogleSheetsService();

            // 2. Ambil data dari DB (termasuk yang cancelled)
            $screenings = Screening::with('pets')->get();

            // 3. Susun array rows
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
                'Pet Status',
                'Boleh Masuk'
            ];

            foreach ($screenings as $s) {
                foreach ($s->pets as $p) {
                    // Tentukan apakah pet boleh masuk berdasarkan kondisi
                    $bolehMasuk = 'Ya';
                    $restrictionReasons = [];

                    // Cek kondisi kutu
                    if (
                        in_array($p->kutu, ['Positif 2', 'Positif 3']) ||
                        ($p->kutu == 'Positif' && $p->kutu_action == 'tidak_periksa')
                    ) {
                        $bolehMasuk = 'Tidak';
                        $restrictionReasons[] = 'Kutu';
                    }

                    // Cek kondisi birahi
                    if (
                        $p->birahi == 'Positif' ||
                        ($p->birahi == 'Positif' && $p->birahi_action == 'tidak_periksa')
                    ) {
                        $bolehMasuk = 'Tidak';
                        $restrictionReasons[] = 'Birahi';
                    }

                    // Gabungkan alasan jika ada
                    $alasanTidakMasuk = $bolehMasuk == 'Tidak' ?
                        'Alasan: ' . implode(', ', $restrictionReasons) : '-';

                    $rows[] = [
                        $s->id,
                        $s->status_text,
                        $s->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d-m-Y H:i:s'),
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
                        $p->status_text,
                        $bolehMasuk,
                        $alasanTidakMasuk
                    ];
                }
            }

            // 4. Gunakan GoogleSheetsService untuk update
            $sheetsService = new \App\Services\GoogleSheetsService();

            // 4a. Set header (overwrite row pertama)
            $sheetsService->setHeader($rows[0], 'Screening!A1');

            // 4b. Clear existing data dari row 2 ke bawah
            $service = $sheetsService->raw();
            $spreadsheetId = config('services.google.spreadsheet_id');

            // Clear range A2:Z1000
            $clearRequest = new \Google\Service\Sheets\ClearValuesRequest();
            $service->spreadsheets_values->clear(
                $spreadsheetId,
                'Screening!A2:Z1000',
                $clearRequest
            );

            // 4c. Append data baru
            $dataRows = array_slice($rows, 1);
            if (!empty($dataRows)) {
                $sheetsService->appendMany($dataRows, 'Screening!A2');
            }

            Log::info('Google Sheets export completed successfully using GoogleSheetsService');

            // Kembalikan response JSON untuk fetch
            return response()->json([
                'success' => true,
                'message' => 'Data exported to Google Sheets successfully',
                'count' => $screenings->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Google Sheets export error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data to Excel (XLSX)
     */
    public function export(Request $request)
    {
        try {
            $search = $request->query('search');
            $status = $request->query('status');
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $fileName = 'Data Screening - ' . date('d F Y') . '.xlsx';

            return Excel::download(
                new ScreeningsExport($search, $status, $startDate, $endDate),
                $fileName
            );

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            return redirect()->route('screening.index')
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Kirim email notifikasi ke Santano
     */
    private function sendEmailNotification($screening)
    {
        try {
            // Email penerima
            $recipients = [
                "appsantano@gmail.com",
                "basiliusarilla06@gmail.com"
            ];

            // Subject berdasarkan status
            $subject = $screening->status == 'completed'
                ? "✅ Screening Baru - " . $screening->owner_name . " - Le Gareca Space"
                : "⚠️ Screening Dibatalkan - " . $screening->owner_name . " - Le Gareca Space";

            // Body email
            $body = $screening->status == 'completed'
                ? "✅ SCREENING BARU — Le Gareca Space ✅\n\n"
                . "Ada input screening baru dari sistem dengan detail berikut:\n\n"
                : "⚠️ SCREENING DIBATALKAN — Le Gareca Space ⚠️\n\n"
                . "Ada screening yang dibatalkan dengan detail berikut:\n\n";

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

                // Tambahkan alasan pembatalan jika ada
                if ($pet->status === 'Tidak Boleh Masuk') {
                    $reasons = [];
                    if (in_array($pet->kutu, ['Positif 2', 'Positif 3'])) {
                        $reasons[] = "Kutu " . $pet->kutu;
                    } elseif ($pet->kutu == 'Positif' && $pet->kutu_action == 'tidak_periksa') {
                        $reasons[] = "Kutu positif (tidak periksa)";
                    } elseif ($pet->birahi == 'Positif') {
                        $reasons[] = "Birahi positif";
                    } elseif ($pet->birahi == 'Positif' && $pet->birahi_action == 'tidak_periksa') {
                        $reasons[] = "Birahi positif (tidak periksa)";
                    }

                    if (!empty($reasons)) {
                        $body .= "  Alasan: " . implode(', ', $reasons) . "\n";
                    }
                }

                $body .= "  ------------------------\n\n";
            }

            $body .= "Terima kasih.\n\n";
            $body .= "© Santano 2026 | Sistem Screening Le Gareca Space";

            // Kirim email ke semua penerima
            Mail::raw($body, function ($message) use ($recipients, $subject) {
                $message->to($recipients)
                    ->subject($subject);
            });

            Log::info('Email notification sent to multiple recipients for screening ID: ' . $screening->id . '. Recipients: ' . implode(', ', $recipients));

        } catch (\Exception $e) {
            Log::error('Failed to send email notification: ' . $e->getMessage());
        }
    }

}