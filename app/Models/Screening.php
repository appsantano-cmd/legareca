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
    public static function saveFromSession(): ?self
    {
        try {
            // Format nomor telepon
            $countryCode = session('country_code', '+62');
            $phoneNumber = session('no_hp');

            if (!$countryCode || !$phoneNumber) {
                throw new \Exception('Country code or phone number is missing');
            }

            $fullPhoneNumber = self::formatPhoneNumber($countryCode, $phoneNumber);

            // Validasi nomor telepon
            if (!self::validatePhoneNumber($fullPhoneNumber)) {
                throw new \Exception('Invalid phone number format');
            }

            // Buat data screening utama
            $screening = self::create([
                'owner_name' => session('owner'),
                'pet_count' => session('count'),
                'phone_number' => $fullPhoneNumber,
                'status' => 'completed'
            ]);

            // Simpan data pets dari session
            $petsData = session('pets', []);
            $screeningResults = session('screening_result', []);

            foreach ($petsData as $index => $pet) {
                $screening->pets()->create([
                    'name' => $pet['name'],
                    'breed' => $pet['breed'],
                    'sex' => $pet['sex'],
                    'age' => $pet['age'],
                    'vaksin' => $screeningResults['pets'][$index]['vaksin'] ?? null,
                    'kutu' => $screeningResults['pets'][$index]['kutu'] ?? null,
                    'kutu_action' => $screeningResults['pets'][$index]['kutu_action'] ?? null,
                    'jamur' => $screeningResults['pets'][$index]['jamur'] ?? null,
                    'birahi' => $screeningResults['pets'][$index]['birahi'] ?? null,
                    'birahi_action' => $screeningResults['pets'][$index]['birahi_action'] ?? null,
                    'kulit' => $screeningResults['pets'][$index]['kulit'] ?? null,
                    'telinga' => $screeningResults['pets'][$index]['telinga'] ?? null,
                    'riwayat' => $screeningResults['pets'][$index]['riwayat'] ?? null,
                    'status' => 'completed'
                ]);
            }

            // ========== PERUBAHAN PENTING ==========
            // Hanya hapus session data yang diperlukan, tapi TETAPKAN screening_id
            // Simpan screening_id ke session sebelum menghapus data lain
            session()->put('screening_id', $screening->id);
            session()->put('cancelled_data_saved', true);

            // Hapus data session yang tidak diperlukan lagi untuk review
            // TAPI jangan hapus semua, biarkan beberapa untuk review data
            $sessionDataToForget = [
                'count', // pet count
                'screening_result', // hasil screening
                'cancel_reasons', // alasan cancel
                'cancelled_data_saved' // flag
            ];

            // Hapus data yang tidak perlu
            session()->forget($sessionDataToForget);

            // Log data session yang tersisa
            \Log::info('Session after saving screening:', [
                'screening_id' => session('screening_id'),
                'owner' => session('owner'),
                'pets' => session('pets'),
                'no_hp' => session('no_hp'),
                'country_code' => session('country_code')
            ]);
            // ========== END PERUBAHAN ==========

            \Log::info('Screening saved successfully', [
                'id' => $screening->id,
                'owner' => $screening->owner_name,
                'phone' => $screening->phone_number,
                'status' => $screening->status
            ]);

            return $screening;

        } catch (\Exception $e) {
            \Log::error('Failed to save screening from session: ' . $e->getMessage());
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