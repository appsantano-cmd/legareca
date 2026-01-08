<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WelcomeVipController extends Controller
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
        return redirect()->route('screening.thankyou');
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
