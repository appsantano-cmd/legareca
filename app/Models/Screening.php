<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'pet_count',
        'phone_number', // sudah termasuk country code
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
            }
            elseif (preg_match('/^(\+\d{1,3})/', $phone, $matches)) {
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
                    'vaksin' => $screeningResults[$index]['vaksin'] ?? null,
                    'kutu' => $screeningResults[$index]['kutu'] ?? null,
                    'jamur' => $screeningResults[$index]['jamur'] ?? null,
                    'birahi' => $screeningResults[$index]['birahi'] ?? null,
                    'kulit' => $screeningResults[$index]['kulit'] ?? null,
                    'telinga' => $screeningResults[$index]['telinga'] ?? null,
                    'riwayat' => $screeningResults[$index]['riwayat'] ?? null,
                ]);
            }

            // Clear session setelah berhasil disimpan
            session()->forget(['owner', 'count', 'country_code', 'no_hp', 'pets', 'screening_result']);

            \Log::info('Screening saved successfully', [
                'id' => $screening->id,
                'owner' => $screening->owner_name,
                'phone' => $screening->phone_number
            ]);

            return $screening;

        } catch (\Exception $e) {
            \Log::error('Failed to save screening from session: ' . $e->getMessage());
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
}