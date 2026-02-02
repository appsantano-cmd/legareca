<?php

namespace App\Http\Controllers;

use App\Models\ArtGallery;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $galleries = ArtGallery::latest()->get();

        return view('art_gallery.pages.index', compact('galleries'));
    }

    public function show(\App\Models\ArtGallery $art)
{
    return view('art_gallery.pages.show', compact('art'));
}

}
