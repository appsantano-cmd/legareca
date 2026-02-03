<?php

namespace App\Http\Controllers;

use App\Models\ArtGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $galleries = ArtGallery::latest()->get();

        // Ubah ini untuk menggunakan view yang sudah ada
        return view('art-gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('art-gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'artist' => 'required|string|max:255',
            'creation_date' => 'required|date',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20971520',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                
                // Validasi file
                if (!$file->isValid()) {
                    return back()->withErrors(['image_path' => 'File tidak valid.']);
                }

                // Buat folder jika belum ada
                $folderPath = 'art_gallery';
                $storagePath = storage_path("app/public/{$folderPath}");
                
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }

                // Generate filename: timestamp_nama-file_artist.ext
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = date('Ymd_His') . '_' . str()->slug($originalName) . '_' . str()->slug($validated['artist']) . '.' . $extension;
                
                // Simpan file
                $path = $file->storeAs($folderPath, $filename, 'public');
                
                $validated['image_path'] = $path;
                
                // Debug: cek path
                \Log::info('Image saved to: ' . $path);
                \Log::info('Full path: ' . storage_path('app/public/' . $path));
            }

            ArtGallery::create($validated);

            return redirect()->route('dashboard')
                ->with('success', 'Karya seni berhasil ditambahkan!');

        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            return back()->withErrors(['image_path' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
        }
    }

    public function show(ArtGallery $art)
    {
        return view('art-gallery.show', compact('art'));
    }
}