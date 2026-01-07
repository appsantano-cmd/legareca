<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // validasi backend
        $request->validate([
            'owner' => 'required|string',
            'count' => 'required|integer|min:1'
        ]);

        session()->put('owner', $request->owner);
        session()->put('count', $request->count);

        return redirect('/screening/pets?count=' . $request->count);
    }

    public function petTable(Request $request)
    {
        return view('screening.pet-table');
    }

    public function screeningResult()
    {
        return view('screening.screening-form', [
            'pets' => session('pets', [])
        ]);
    }

    public function submitScreeningResult(Request $request)
    {
        $count = session('count', 0);

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

        // Simpan hasil screening
        session()->put('screening_result', $request->pets);

        return redirect()->route('screening.welcome')
            ->with('success', 'Screening berhasil disimpan!');
    }

    public function submitPets(Request $request)
    {
        $request->validate([
            'pets' => 'required|array|min:1',
            'pets.*.name' => 'required|string',
            'pets.*.sex' => 'required|string',
            'pets.*.age' => 'required|integer|min:0',
        ]);

        session()->put('pets', $request->pets);

        return redirect()->route('screening.result');
    }
}
