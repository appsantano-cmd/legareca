<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Traits\Loggable;

class Screening extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'owner_name',
        'pet_count',
        'phone_number',
        'status'
    ];

    protected $casts = [
        'pet_count' => 'integer'
    ];

    /**
     * Relasi ke pets
     */
    public function pets(): HasMany
    {
        return $this->hasMany(ScreeningPet::class);
    }

    /**
     * Accessor untuk mendapatkan hanya nomor tanpa country code
     */
    public function getPhoneNumberWithoutCodeAttribute(): string
    {
        // Hapus country code (+62, +1, dll)
        $phone = $this->phone_number;

        // Jika dimulai dengan +, hapus country code
        if (str_starts_with($phone, '+')) {
            // Untuk Indonesia (+62) hapus 3 karakter pertama
            if (str_starts_with($phone, '+62')) {
                return substr($phone, 3);
            }
            // Untuk country code lain dengan 2 digit (contoh: +1, +44)
            elseif (preg_match('/^\+\d{1,3}/', $phone, $matches)) {
                return substr($phone, strlen($matches[0]));
            }
        }

        return $phone;
    }

    /**
     * Accessor untuk mendapatkan hanya country code
     */
    public function getCountryCodeAttribute(): string
    {
        $phone = $this->phone_number;

        if (str_starts_with($phone, '+')) {
            if (str_starts_with($phone, '+62')) {
                return '+62';
            } elseif (preg_match('/^(\+\d{1,3})/', $phone, $matches)) {
                return $matches[1];
            }
        }

        return '+62'; // default
    }

    /**
     * Accessor untuk format tampilan yang rapi
     */
    public function getFormattedPhoneAttribute(): string
    {
        $phone = $this->phone_number;

        // Format: +62 812-3456-7890
        if (str_starts_with($phone, '+62')) {
            $number = substr($phone, 3);
            if (strlen($number) >= 10) {
                return '+62 ' . substr($number, 0, 3) . '-' . substr($number, 3, 4) . '-' . substr($number, 7);
            }
        }

        return $phone;
    }

    /**
     * Scope untuk mencari berdasarkan nomor telepon
     */
    public function scopeSearchByPhone($query, $phone)
    {
        // Hilangkan spasi dan karakter khusus
        $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
        return $query->where('phone_number', 'like', "%{$cleanPhone}%");
    }

    /**
     * Scope untuk mencari berdasarkan nama pemilik
     */
    public function scopeSearchByOwner($query, $ownerName)
    {
        return $query->where('owner_name', 'like', "%{$ownerName}%");
    }

    /**
     * Scope untuk screening yang cancelled
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope untuk screening yang completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Validasi dan format nomor telepon
     */
    public static function formatPhoneNumber($countryCode, $phoneNumber): string
    {
        // Hilangkan spasi dan karakter khusus dari phone number
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Jika phone number sudah dimulai dengan 0, hapus 0 pertama
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = substr($cleanPhone, 1);
        }

        // Gabungkan dengan country code
        return $countryCode . $cleanPhone;
    }

    /**
     * Validasi data sebelum disimpan
     */
    public static function validatePhoneNumber($phoneNumber): bool
    {
        // Format: +6281234567890 (minimal 10 digit setelah country code)
        $pattern = '/^\+\d{1,3}\d{8,13}$/';
        return preg_match($pattern, $phoneNumber);
    }

    /**
     * Simpan data screening dari session dengan struktur baru
     */
    /**
     * Save screening data from session
     */
    public static function saveFromSession()
    {
        try {
            \Log::info('=== SAVE FROM SESSION START ===');

            $ownerName = session('owner');
            $phoneNumber = Screening::formatPhoneNumber(
                session('country_code', '+62'),
                session('no_hp')
            );
            $petCount = session('count', 1);
            $petsData = session('pets', []);
            $screeningData = session('screening_result', []);
            $cancelReasons = session('cancel_reasons', []);
            $hasCancelledPet = session('has_cancelled_pet', false);

            \Log::info('Session data for save:', [
                'owner' => $ownerName,
                'phone' => $phoneNumber,
                'pet_count' => $petCount,
                'pets_data_count' => count($petsData),
                'screening_data_count' => count($screeningData),
                'has_cancelled_pet' => $hasCancelledPet,
                'cancel_reasons' => $cancelReasons
            ]);

            // Determine overall status
            // Jika ada minimal satu pet yang cancelled, maka screening status = cancelled
            // Jika tidak ada pet yang cancelled, status = completed
            $overallStatus = $hasCancelledPet ? 'cancelled' : 'completed';

            \Log::info('Overall screening status determined: ' . $overallStatus);

            // Create screening record
            $screening = new Screening();
            $screening->owner_name = $ownerName;
            $screening->phone_number = $phoneNumber;
            $screening->pet_count = $petCount;
            $screening->status = $overallStatus; // Set status berdasarkan kondisi
            $screening->save();

            \Log::info('Screening record created. ID: ' . $screening->id . ', Status: ' . $overallStatus);

            // Save pets data
            if (isset($screeningData['pets']) && is_array($screeningData['pets'])) {
                foreach ($screeningData['pets'] as $index => $petData) {
                    $pet = new ScreeningPet();
                    $pet->screening_id = $screening->id;

                    // Basic pet info from session
                    $petSessionData = $petsData[$index] ?? [];
                    $pet->name = $petSessionData['name'] ?? 'Anabul ' . ($index + 1);
                    $pet->breed = $petSessionData['breed'] ?? '';
                    $pet->sex = $petSessionData['sex'] ?? '';
                    $pet->age = $petSessionData['age'] ?? '';

                    // Screening results from form
                    $pet->vaksin = $petData['vaksin'] ?? '-';
                    $pet->kutu = $petData['kutu'] ?? '-';
                    $pet->jamur = $petData['jamur'] ?? '-';
                    $pet->birahi = $petData['birahi'] ?? '-';
                    $pet->kulit = $petData['kulit'] ?? '-';
                    $pet->telinga = $petData['telinga'] ?? '-';
                    $pet->riwayat = $petData['riwayat'] ?? '-';

                    // Kutu action (if exists)
                    $pet->kutu_action = $petData['kutu_action'] ?? null;

                    // Birahi action (if exists)
                    $pet->birahi_action = $petData['birahi_action'] ?? null;

                    // Determine pet status
                    $petStatus = 'Normal'; // Default
                    $petCancelled = false;

                    // Check if this pet is cancelled
                    foreach ($cancelReasons as $reason) {
                        if ($reason['pet_index'] == $index) {
                            $petCancelled = true;
                            break;
                        }
                    }

                    // Set pet status
                    if ($petCancelled) {
                        $petStatus = 'Tidak Boleh Masuk';
                    } elseif ($petData['kutu'] === 'Positif' && isset($petData['kutu_action']) && $petData['kutu_action'] === 'lanjut_obat') {
                        $petStatus = 'Lanjut Obat';
                    } elseif (in_array($petData['kutu'], ['Positif', 'Positif 2', 'Positif 3'])) {
                        // Jika kutu positif tanpa action atau dengan action null, tetap ditandai
                        if ($petData['kutu'] === 'Positif' && (!isset($petData['kutu_action']) || $petData['kutu_action'] === null)) {
                            $petStatus = 'Kutu Positif';
                        } elseif (in_array($petData['kutu'], ['Positif 2', 'Positif 3'])) {
                            $petStatus = 'Tidak Boleh Masuk';
                        } else {
                            $petStatus = 'Kutu Positif';
                        }
                    } elseif ($petData['birahi'] === 'Positif') {
                        $petStatus = 'Tidak Boleh Masuk';
                    } else {
                        $petStatus = 'Normal';
                    }

                    $pet->status = $petStatus;
                    $pet->save();

                    \Log::info("Pet {$index} saved. Name: {$pet->name}, Status: {$petStatus}");
                }
            }

            // Clear session data after save
            session()->forget([
                'owner',
                'count',
                'pets',
                'screening_result',
                'no_hp',
                'country_code',
                'cancel_reasons',
                'has_cancelled_pet'
            ]);

            \Log::info('=== SAVE FROM SESSION COMPLETE ===');

            return $screening;

        } catch (\Exception $e) {
            \Log::error('Failed to save screening from session: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    /**
     * Helper function untuk mendapatkan nilai yang valid untuk database
     */
    private static function getValidValueForDatabase($field, $value)
    {
        // Mapping nilai yang valid untuk setiap field
        $validValues = [
            'vaksin' => ['Belum', 'Belum lengkap', 'Sudah lengkap'],
            'kutu' => ['Negatif', 'Positif', 'Positif 2', 'Positif 3'],
            'jamur' => ['Negatif', 'Positif', 'Positif 2', 'Positif 3'],
            'birahi' => ['Negatif', 'Positif'],
            'kulit' => ['Negatif', 'Positif', 'Positif 2', 'Positif 3'],
            'telinga' => ['Negatif', 'Positif', 'Positif 2', 'Positif 3'],
            'riwayat' => ['Sehat', 'Pasca terapi', 'Sedang terapi'],
            'kutu_action' => ['lanjut_obat', 'tidak_periksa'],
            'birahi_action' => ['lanjut_obat', 'tidak_periksa']
        ];

        // Jika field tidak ada di mapping, return nilai asli
        if (!isset($validValues[$field])) {
            return $value ?? 'tidak_ada';
        }

        // Jika nilai kosong atau tidak ada, return nilai pertama dari array
        if (empty($value)) {
            return $validValues[$field][0];
        }

        // Jika nilai ada di array valid values, gunakan
        if (in_array($value, $validValues[$field])) {
            return $value;
        }

        // Jika tidak, gunakan nilai pertama
        return $validValues[$field][0];
    }

    /**
     * Simpan data screening yang dibatalkan
     */
    public static function saveCancelledData()
    {
        try {
            \Log::info('=== SAVE CANCELLED DATA START ===');

            \DB::beginTransaction();

            // Format nomor telepon jika ada
            $phoneNumber = '-';
            if (session('no_hp')) {
                $countryCode = session('country_code', '+62');
                $phoneNumber = self::formatPhoneNumber($countryCode, session('no_hp'));
            }

            // Buat screening record
            $screening = self::create([
                'owner_name' => session('owner', 'Tidak diketahui'),
                'pet_count' => count(session('pets', [])),
                'phone_number' => $phoneNumber,
                'status' => 'cancelled'
            ]);

            \Log::info('Screening record created! ID: ' . $screening->id);

            // ========== TAMBAHKAN INI ==========
            // Simpan screening_id ke session untuk review data
            session()->put('screening_id', $screening->id);
            // ========== END TAMBAHAN ==========

            // Simpan data pets (jika ada)
            $screeningResult = session('screening_result', []);
            $petsData = session('pets', []);

            \Log::info('Session data for saving pets:', [
                'pets_data' => $petsData,
                'screening_result' => $screeningResult,
                'pets_count' => count($petsData)
            ]);

            if (!empty($petsData)) {
                \Log::info('Saving pets data...');

                foreach ($petsData as $index => $pet) {
                    $petData = $screeningResult['pets'][$index] ?? [];

                    \Log::info("Processing pet {$index}:", [
                        'pet_info' => $pet,
                        'screening_data' => $petData
                    ]);

                    // ========== PERUBAHAN UTAMA ==========
                    // Gunakan nilai "-" sebagai placeholder untuk field yang tidak diisi
                    // JANGAN diubah menjadi null karena ENUM sudah mendukung "-"
                    $vaksin = $petData['vaksin'] ?? '-';
                    $kutu = $petData['kutu'] ?? '-';
                    $kutu_action = $petData['kutu_action'] ?? null;
                    $jamur = $petData['jamur'] ?? '-';
                    $birahi = $petData['birahi'] ?? '-';
                    $birahi_action = $petData['birahi_action'] ?? null;
                    $kulit = $petData['kulit'] ?? '-';
                    $telinga = $petData['telinga'] ?? '-';
                    $riwayat = $petData['riwayat'] ?? '-';

                    $petRecord = [
                        'screening_id' => $screening->id,
                        'name' => $pet['name'] ?? 'Anabul ' . ($index + 1),
                        'breed' => $pet['breed'] ?? 'Tidak diketahui',
                        'sex' => $pet['sex'] ?? 'Tidak diketahui',
                        'age' => $pet['age'] ?? 'Tidak diketahui',
                        'vaksin' => $vaksin,
                        'kutu' => $kutu,
                        'kutu_action' => $kutu_action,
                        'jamur' => $jamur,
                        'birahi' => $birahi,
                        'birahi_action' => $birahi_action,
                        'kulit' => $kulit,
                        'telinga' => $telinga,
                        'riwayat' => $riwayat,
                        'status' => 'cancelled'
                    ];

                    \Log::info("Pet record to save #{$index}:", $petRecord);

                    try {
                        ScreeningPet::create($petRecord);
                        \Log::info("Pet #{$index} saved successfully");
                    } catch (\Exception $e) {
                        \Log::error("Failed to save pet #{$index}: " . $e->getMessage());
                        \Log::error("Pet data that caused error:", $petRecord);
                        throw $e; // Re-throw agar rollback bekerja
                    }
                }
            }

            \DB::commit();

            \Log::info('Cancelled screening data saved successfully!');

            return $screening;

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('saveCancelledData error: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());

            return null;
        }
    }

    /**
     * Dapatkan informasi kontak lengkap
     */
    public function getContactInfoAttribute(): array
    {
        return [
            'full_number' => $this->phone_number,
            'country_code' => $this->country_code,
            'local_number' => $this->phone_number_without_code,
            'formatted' => $this->formatted_phone,
            'whatsapp_link' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $this->phone_number)
        ];
    }

    /**
     * Format status untuk tampilan
     */
    public function getStatusTextAttribute()
    {
        return [
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ]
        [$this->status] ?? 'Unknown';
    }
}