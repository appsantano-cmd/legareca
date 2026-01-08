<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Screening;

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
}
