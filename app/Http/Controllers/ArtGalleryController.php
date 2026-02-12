<?php

namespace App\Http\Controllers;

use App\Models\ArtGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $ongoing = ArtGallery::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date')
            ->get();

        $upcoming = ArtGallery::where('start_date', '>', $today)
            ->orderBy('start_date')
            ->get();

        $past = ArtGallery::where('end_date', '<', $today)
            ->orderByDesc('end_date')
            ->get();

        return view('art-gallery.index', compact(
            'ongoing',
            'upcoming',
            'past'
        ));
    }

    public function create()
    {
        return view('art-gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480', // 20MB
        ]);

        // Upload image
        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')
                ->store('art-galleries', 'public');
        }

        ArtGallery::create($validated);

        return redirect()
            ->route('gallery.create')
            ->with('success', 'Karya seni berhasil ditambahkan!');
    }

    public function show(ArtGallery $art)
    {
        return view('art-gallery.show', compact('art'));
    }
}