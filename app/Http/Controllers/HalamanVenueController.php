<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanVenueController extends Controller
{
    /**
     * Display venue information page
     */
    public function index()
    {
        return view('halamanvenue.index');
    }
}