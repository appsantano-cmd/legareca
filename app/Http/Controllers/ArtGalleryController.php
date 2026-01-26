<?php

namespace App\Http\Controllers;

use App\Models\ArtGallery;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $galleries = ArtGallery::latest()->get();

        // Ubah ini untuk menggunakan view yang sudah ada
        return view('art-gallery.index', compact('galleries'));
    }
}