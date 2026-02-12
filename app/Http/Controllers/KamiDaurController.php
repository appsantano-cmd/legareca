<?php
// app/Http/Controllers/KamiDaurController.php

namespace App\Http\Controllers;

use App\Models\KamiDaur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class KamiDaurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('KamiDaurController: Mengakses halaman index');
        $kamiDaurs = KamiDaur::orderBy('created_at', 'desc')->paginate(10);
        return view('kami-daur.index', compact('kamiDaurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('KamiDaurController: Mengakses halaman create');
        return view('kami-daur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('KamiDaurController: Memulai proses store', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'has_files' => $request->hasFile('products') || $request->hasFile('materials'),
            'all_files' => array_keys($request->allFiles()),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'input_keys' => array_keys($request->all()),
            'server' => [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
                'memory_limit' => ini_get('memory_limit'),
            ]
        ]);

        // CEK ERROR UPLOAD FILE
        if ($request->hasFile('products')) {
            foreach ($request->file('products') as $key => $file) {
                if (isset($file['image_file'])) {
                    $uploadedFile = $file['image_file'];
                    Log::info('KamiDaurController: Detail file produk', [
                        'index' => $key,
                        'original_name' => $uploadedFile->getClientOriginalName(),
                        'extension' => $uploadedFile->getClientOriginalExtension(),
                        'size' => $uploadedFile->getSize(),
                        'mime' => $uploadedFile->getMimeType(),
                        'error' => $uploadedFile->getError(),
                        'error_message' => $this->getUploadErrorMessage($uploadedFile->getError()),
                        'is_valid' => $uploadedFile->isValid(),
                        'path' => $uploadedFile->getPathname(),
                        'tmp_name' => $_FILES['products']['tmp_name'][$key]['image_file'] ?? 'not set',
                    ]);
                }
            }
        }

        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $key => $file) {
                if (isset($file['image_file'])) {
                    $uploadedFile = $file['image_file'];
                    Log::info('KamiDaurController: Detail file material', [
                        'index' => $key,
                        'original_name' => $uploadedFile->getClientOriginalName(),
                        'extension' => $uploadedFile->getClientOriginalExtension(),
                        'size' => $uploadedFile->getSize(),
                        'mime' => $uploadedFile->getMimeType(),
                        'error' => $uploadedFile->getError(),
                        'error_message' => $this->getUploadErrorMessage($uploadedFile->getError()),
                        'is_valid' => $uploadedFile->isValid(),
                        'path' => $uploadedFile->getPathname()
                    ]);
                }
            }
        }

        try {
            $validated = $request->validate([
                // Hero Section
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string|max:255',
                'hero_description' => 'nullable|string',

                // About Section
                'about_title' => 'nullable|string|max:255',
                'about_description' => 'nullable|string',

                // Mission Items
                'mission_items' => 'nullable|array',
                'mission_items.*' => 'nullable|string|max:255',

                // Contact
                'contact_phone' => 'nullable|string|max:50',
                'contact_email' => 'nullable|email|max:255',
                'contact_address' => 'nullable|string',

                // Products
                'products' => 'nullable|array',
                'products.*.name' => 'nullable|string|max:255',
                'products.*.price' => 'nullable|numeric',
                'products.*.description' => 'nullable|string',
                'products.*.image' => 'nullable|string',
                'products.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480', // HAPUS heic,heif dulu
                'products.*.features' => 'nullable|array',
                'products.*.is_new' => 'nullable|boolean',
                'products.*.is_bestseller' => 'nullable|boolean',

                // Materials
                'materials' => 'nullable|array',
                'materials.*.name' => 'nullable|string|max:255',
                'materials.*.description' => 'nullable|string',
                'materials.*.image' => 'nullable|string',
                'materials.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480', // HAPUS heic,heif dulu
                'materials.*.info' => 'nullable|string',

                // Impact Stats
                'impact_stats' => 'nullable|array',
                'impact_stats.*.label' => 'nullable|string|max:255',
                'impact_stats.*.value' => 'nullable|string|max:255',
                'impact_stats.*.icon' => 'nullable|string|max:50',

                // Store Info
                'opening_hours' => 'nullable|string|max:255',

                // Services
                'services' => 'nullable|array',
                'services.*.title' => 'nullable|string|max:255',
                'services.*.description' => 'nullable|string',
                'services.*.icon' => 'nullable|string|max:50',

                // Payment Methods
                'payment_methods' => 'nullable|array',
                'payment_methods.*' => 'nullable|string|max:100',

                // Shipping
                'shipping_info' => 'nullable|string',
                'free_shipping_minimum' => 'nullable|numeric',

                // SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',

                // Status
                'is_active' => 'boolean'
            ]);

            Log::info('KamiDaurController: Validasi berhasil', [
                'product_count' => isset($validated['products']) ? count($validated['products']) : 0,
                'material_count' => isset($validated['materials']) ? count($validated['materials']) : 0,
                'is_active' => $validated['is_active'] ?? false
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('KamiDaurController: Validasi gagal', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token']),
                'files' => $_FILES
            ]);

            // Redirect back with errors and input
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }

        // Proses upload gambar produk
        if ($request->has('products')) {
            foreach ($validated['products'] as $key => $product) {
                if ($request->hasFile("products.{$key}.image_file")) {
                    try {
                        $file = $request->file("products.{$key}.image_file");

                        if (!$file->isValid()) {
                            throw new \Exception('File tidak valid: ' . $this->getUploadErrorMessage($file->getError()));
                        }

                        $validated['products'][$key]['image'] = $this->uploadImage($file, 'products');

                        Log::info('KamiDaurController: Upload file produk berhasil', [
                            'product_index' => $key,
                            'image_path' => $validated['products'][$key]['image']
                        ]);

                    } catch (\Exception $e) {
                        Log::error('KamiDaurController: Gagal upload file produk', [
                            'product_index' => $key,
                            'error' => $e->getMessage()
                        ]);

                        return redirect()->back()
                            ->with('error', 'Gagal upload gambar produk: ' . $e->getMessage())
                            ->withInput();
                    }
                }
                unset($validated['products'][$key]['image_file']);
            }
        }

        // Proses upload gambar material
        if ($request->has('materials')) {
            foreach ($validated['materials'] as $key => $material) {
                if ($request->hasFile("materials.{$key}.image_file")) {
                    try {
                        $file = $request->file("materials.{$key}.image_file");

                        if (!$file->isValid()) {
                            throw new \Exception('File tidak valid: ' . $this->getUploadErrorMessage($file->getError()));
                        }

                        $validated['materials'][$key]['image'] = $this->uploadImage($file, 'materials');

                        Log::info('KamiDaurController: Upload file material berhasil', [
                            'material_index' => $key,
                            'image_path' => $validated['materials'][$key]['image']
                        ]);

                    } catch (\Exception $e) {
                        Log::error('KamiDaurController: Gagal upload file material', [
                            'material_index' => $key,
                            'error' => $e->getMessage()
                        ]);

                        return redirect()->back()
                            ->with('error', 'Gagal upload gambar material: ' . $e->getMessage())
                            ->withInput();
                    }
                }
                unset($validated['materials'][$key]['image_file']);
            }
        }

        try {
            // Set previous active to false if this one is active
            if ($request->has('is_active') && $request->is_active) {
                KamiDaur::where('is_active', true)->update(['is_active' => false]);
            }

            $kamiDaur = KamiDaur::create($validated);

            Log::info('KamiDaurController: Data berhasil disimpan', [
                'id' => $kamiDaur->id
            ]);

        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal menyimpan ke database', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('kami-daur.index')
            ->with('success', 'Kami Daur configuration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Menampilkan detail', [
            'id' => $kamiDaur->id,
            'created_at' => $kamiDaur->created_at->toDateTimeString()
        ]);

        return view('kami-daur.show', compact('kamiDaur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Mengakses halaman edit', [
            'id' => $kamiDaur->id,
            'is_active' => $kamiDaur->is_active
        ]);

        return view('kami-daur.edit', compact('kamiDaur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Memulai proses update', [
            'id' => $kamiDaur->id,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'has_files' => $request->hasFile('products') || $request->hasFile('materials')
        ]);

        try {
            $validated = $request->validate([
                // Hero Section
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string|max:255',
                'hero_description' => 'nullable|string',

                // About Section
                'about_title' => 'nullable|string|max:255',
                'about_description' => 'nullable|string',

                // Mission Items
                'mission_items' => 'nullable|array',
                'mission_items.*' => 'nullable|string|max:255',

                // Contact
                'contact_phone' => 'nullable|string|max:50',
                'contact_email' => 'nullable|email|max:255',
                'contact_address' => 'nullable|string',

                // Products
                'products' => 'nullable|array',
                'products.*.name' => 'nullable|string|max:255',
                'products.*.price' => 'nullable|numeric',
                'products.*.description' => 'nullable|string',
                'products.*.image' => 'nullable|string',
                'products.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,heic,heif|max:20480',
                'products.*.features' => 'nullable|array',
                'products.*.is_new' => 'nullable|boolean',
                'products.*.is_bestseller' => 'nullable|boolean',

                // Materials
                'materials' => 'nullable|array',
                'materials.*.name' => 'nullable|string|max:255',
                'materials.*.description' => 'nullable|string',
                'materials.*.image' => 'nullable|string',
                'materials.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,heic,heif|max:20480',
                'materials.*.info' => 'nullable|string',

                // Impact Stats
                'impact_stats' => 'nullable|array',
                'impact_stats.*.label' => 'nullable|string|max:255',
                'impact_stats.*.value' => 'nullable|string|max:255',
                'impact_stats.*.icon' => 'nullable|string|max:50',

                // Store Info
                'opening_hours' => 'nullable|string|max:255',

                // Services
                'services' => 'nullable|array',
                'services.*.title' => 'nullable|string|max:255',
                'services.*.description' => 'nullable|string',
                'services.*.icon' => 'nullable|string|max:50',

                // Payment Methods
                'payment_methods' => 'nullable|array',
                'payment_methods.*' => 'nullable|string|max:100',

                // Shipping
                'shipping_info' => 'nullable|string',
                'free_shipping_minimum' => 'nullable|numeric',

                // SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',

                // Status
                'is_active' => 'boolean'
            ]);

            Log::info('KamiDaurController: Validasi update berhasil', [
                'id' => $kamiDaur->id,
                'product_count' => isset($validated['products']) ? count($validated['products']) : 0,
                'material_count' => isset($validated['materials']) ? count($validated['materials']) : 0
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('KamiDaurController: Validasi update gagal', [
                'id' => $kamiDaur->id,
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        try {
            // Proses upload gambar produk
            if ($request->has('products')) {
                Log::info('KamiDaurController: Memproses update gambar produk', [
                    'id' => $kamiDaur->id,
                    'total_products' => count($validated['products'])
                ]);

                foreach ($validated['products'] as $key => $product) {
                    // Cek apakah ada file gambar yang diupload
                    if ($request->hasFile("products.{$key}.image_file")) {
                        try {
                            // Hapus gambar lama jika ada
                            if (isset($kamiDaur->products[$key]['image']) && $kamiDaur->products[$key]['image']) {
                                Log::info('KamiDaurController: Menghapus gambar produk lama', [
                                    'id' => $kamiDaur->id,
                                    'product_index' => $key,
                                    'old_image' => $kamiDaur->products[$key]['image']
                                ]);

                                $this->deleteImage($kamiDaur->products[$key]['image']);
                            }

                            $file = $request->file("products.{$key}.image_file");

                            Log::info('KamiDaurController: Upload file produk baru', [
                                'id' => $kamiDaur->id,
                                'product_index' => $key,
                                'original_name' => $file->getClientOriginalName(),
                                'extension' => $file->getClientOriginalExtension(),
                                'size' => $file->getSize()
                            ]);

                            $validated['products'][$key]['image'] = $this->uploadImage($file, 'products');

                            Log::info('KamiDaurController: Upload file produk baru berhasil', [
                                'id' => $kamiDaur->id,
                                'product_index' => $key,
                                'new_image' => $validated['products'][$key]['image']
                            ]);

                        } catch (\Exception $e) {
                            Log::error('KamiDaurController: Gagal update file produk', [
                                'id' => $kamiDaur->id,
                                'product_index' => $key,
                                'error' => $e->getMessage()
                            ]);
                            throw $e;
                        }
                    }
                    // Hapus field image_file dari data yang akan disimpan
                    unset($validated['products'][$key]['image_file']);
                }
            }

            // Proses upload gambar material
            if ($request->has('materials')) {
                Log::info('KamiDaurController: Memproses update gambar material', [
                    'id' => $kamiDaur->id,
                    'total_materials' => count($validated['materials'])
                ]);

                foreach ($validated['materials'] as $key => $material) {
                    // Cek apakah ada file gambar yang diupload
                    if ($request->hasFile("materials.{$key}.image_file")) {
                        try {
                            // Hapus gambar lama jika ada
                            if (isset($kamiDaur->materials[$key]['image']) && $kamiDaur->materials[$key]['image']) {
                                Log::info('KamiDaurController: Menghapus gambar material lama', [
                                    'id' => $kamiDaur->id,
                                    'material_index' => $key,
                                    'old_image' => $kamiDaur->materials[$key]['image']
                                ]);

                                $this->deleteImage($kamiDaur->materials[$key]['image']);
                            }

                            $file = $request->file("materials.{$key}.image_file");

                            Log::info('KamiDaurController: Upload file material baru', [
                                'id' => $kamiDaur->id,
                                'material_index' => $key,
                                'original_name' => $file->getClientOriginalName(),
                                'extension' => $file->getClientOriginalExtension(),
                                'size' => $file->getSize()
                            ]);

                            $validated['materials'][$key]['image'] = $this->uploadImage($file, 'materials');

                            Log::info('KamiDaurController: Upload file material baru berhasil', [
                                'id' => $kamiDaur->id,
                                'material_index' => $key,
                                'new_image' => $validated['materials'][$key]['image']
                            ]);

                        } catch (\Exception $e) {
                            Log::error('KamiDaurController: Gagal update file material', [
                                'id' => $kamiDaur->id,
                                'material_index' => $key,
                                'error' => $e->getMessage()
                            ]);
                            throw $e;
                        }
                    }
                    // Hapus field image_file dari data yang akan disimpan
                    unset($validated['materials'][$key]['image_file']);
                }
            }

        } catch (\Exception $e) {
            Log::error('KamiDaurController: Error saat proses update file', [
                'id' => $kamiDaur->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

        try {
            // Set previous active to false if this one is active
            if ($request->has('is_active') && $request->is_active && !$kamiDaur->is_active) {
                Log::info('KamiDaurController: Mengupdate active status', [
                    'id' => $kamiDaur->id,
                    'old_active_count' => KamiDaur::where('is_active', true)->count()
                ]);

                KamiDaur::where('is_active', true)->update(['is_active' => false]);

                Log::info('KamiDaurController: Update active status selesai');
            }

            Log::info('KamiDaurController: Menyimpan update ke database', [
                'id' => $kamiDaur->id,
                'data' => [
                    'product_count' => isset($validated['products']) ? count($validated['products']) : 0,
                    'material_count' => isset($validated['materials']) ? count($validated['materials']) : 0,
                    'is_active' => $validated['is_active'] ?? $kamiDaur->is_active
                ]
            ]);

            $kamiDaur->update($validated);

            Log::info('KamiDaurController: Update database berhasil', [
                'id' => $kamiDaur->id,
                'updated_at' => $kamiDaur->updated_at->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal update database', [
                'id' => $kamiDaur->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

        Log::info('KamiDaurController: Proses update selesai, redirect ke index', [
            'id' => $kamiDaur->id
        ]);

        return redirect()->route('kami-daur.index')
            ->with('success', 'Kami Daur configuration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Memulai proses delete', [
            'id' => $kamiDaur->id,
            'product_count' => $kamiDaur->products ? count($kamiDaur->products) : 0,
            'material_count' => $kamiDaur->materials ? count($kamiDaur->materials) : 0
        ]);

        try {
            // Hapus semua gambar terkait
            if ($kamiDaur->products) {
                Log::info('KamiDaurController: Menghapus gambar produk', [
                    'id' => $kamiDaur->id,
                    'total' => count($kamiDaur->products)
                ]);

                foreach ($kamiDaur->products as $index => $product) {
                    if (isset($product['image']) && $product['image']) {
                        $this->deleteImage($product['image']);
                        Log::info('KamiDaurController: Gambar produk dihapus', [
                            'id' => $kamiDaur->id,
                            'product_index' => $index,
                            'image' => $product['image']
                        ]);
                    }
                }
            }

            if ($kamiDaur->materials) {
                Log::info('KamiDaurController: Menghapus gambar material', [
                    'id' => $kamiDaur->id,
                    'total' => count($kamiDaur->materials)
                ]);

                foreach ($kamiDaur->materials as $index => $material) {
                    if (isset($material['image']) && $material['image']) {
                        $this->deleteImage($material['image']);
                        Log::info('KamiDaurController: Gambar material dihapus', [
                            'id' => $kamiDaur->id,
                            'material_index' => $index,
                            'image' => $material['image']
                        ]);
                    }
                }
            }

            $kamiDaur->delete();

            Log::info('KamiDaurController: Delete berhasil', [
                'id' => $kamiDaur->id
            ]);

        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal delete', [
                'id' => $kamiDaur->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

        return redirect()->route('kami-daur.index')
            ->with('success', 'Kami Daur configuration deleted successfully.');
    }

    /**
     * Menampilkan halaman Kami Daur
     */
    public function home()
    {
        Log::info('KamiDaurController: Mengakses halaman home');

        $config = KamiDaur::getActive();

        if (!$config) {
            Log::info('KamiDaurController: Tidak ada config active, menggunakan default');

            $config = new KamiDaur();
            $config->hero_title = 'BUTIK BAJU DAUR ULANG';
            $config->hero_subtitle = 'Fashion Berkelanjutan untuk Bumi yang Lebih Hijau';
            $config->hero_description = 'Setiap pakaian yang kami buat adalah cerita tentang perubahan - dari limbah menjadi karya seni yang bermakna, dari sampah menjadi fashion yang stylish dan ramah lingkungan.';

            $config->mission_items = [
                'Setiap produk menyelamatkan 1kg limbah',
                'Menggunakan pewarna alami ramah lingkungan',
                'Mendukung pengrajin lokal',
                'Transparansi proses produksi'
            ];

            $config->contact_phone = '6281234567890';
            $config->contact_email = 'kami.daur@example.com';
            $config->contact_address = 'Jl. Lingkungan Hijau No. 123, Kota Ramah Lingkungan';

            $config->products = [
                [
                    'name' => 'Jaket Denim Daur Ulang',
                    'price' => 299000,
                    'image' => 'https://images.unsplash.com/photo-1558769132-cb1cdeede',
                    'description' => 'Jaket denim stylish dari bahan jeans bekas berkualitas tinggi',
                    'features' => ['100% bahan daur ulang', 'Limited edition', 'Eco-friendly dye'],
                    'is_new' => true
                ],
                [
                    'name' => 'Dress Botol Plastik',
                    'price' => 459000,
                    'image' => 'https://images.unsplash.com/photo-1567401893414',
                    'description' => 'Dress elegan terbuat dari botol plastik daur ulang',
                    'features' => ['22 botol plastik', 'Anti-bacterial', 'Water resistant'],
                    'is_bestseller' => true
                ],
                [
                    'name' => 'Tas Ransel Kain Perca',
                    'price' => 189000,
                    'image' => 'https://images.unsplash.com/photo-1553062407',
                    'description' => 'Tas unik dari sisa kain perca dengan desain modern',
                    'features' => ['Handmade', 'Setiap tas unik', 'Waterproof lining']
                ]
            ];

            $config->materials = [
                [
                    'name' => 'Botol Plastik',
                    'description' => 'Botol plastik PET didaur ulang menjadi benang polyester untuk bahan pakaian berkualitas.',
                    'image' => 'https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63',
                    'info' => '10 botol = 1 kaos'
                ],
                [
                    'name' => 'Kain Perca',
                    'description' => 'Sisa kain dari industri garmen diolah menjadi produk baru dengan desain unik dan kreatif.',
                    'image' => 'https://images.unsplash.com/photo-1562077981-1e3eab3c8c7a',
                    'info' => 'Zero waste production'
                ],
                [
                    'name' => 'Denim Bekas',
                    'description' => 'Jeans bekas diproses menjadi serat baru untuk koleksi denim sustainable kami.',
                    'image' => 'https://images.unsplash.com/photo-1578551124695-5c2c6c6c6c6c',
                    'info' => 'Natural indigo dye'
                ]
            ];

            $config->impact_stats = [
                ['label' => 'Botol Plastik', 'value' => '5,000+', 'icon' => 'fa-recycle'],
                ['label' => 'Pakaian Terjual', 'value' => '2,500+', 'icon' => 'fa-tshirt'],
                ['label' => 'Pengrajin', 'value' => '50+', 'icon' => 'fa-users']
            ];

            $config->opening_hours = 'Senin-Sabtu 10:00-20:00';
            $config->free_shipping_minimum = 500000;

            $config->services = [
                ['title' => 'Custom Size', 'description' => 'Kami menerima pemesanan ukuran custom untuk kenyamanan maksimal.', 'icon' => 'fa-ruler'],
                ['title' => 'Custom Design', 'description' => 'Ingin desain khusus? Konsultasikan ide Anda dengan desainer kami.', 'icon' => 'fa-palette'],
                ['title' => 'Free Delivery', 'description' => 'Gratis pengiriman untuk pembelian di atas Rp 500.000.', 'icon' => 'fa-truck']
            ];

            $config->payment_methods = ['Transfer Bank', 'E-Wallet', 'COD', 'Kredit'];
            $config->shipping_info = 'Gratis pengiriman untuk pembelian di atas Rp 500.000';
            $config->meta_title = 'Kami Daur - Tentang Kami';
            $config->meta_description = 'Kami Daur adalah platform yang berkomitmen untuk mendukung gerakan daur ulang dan pelestarian lingkungan.';
        }

        $data = [
            'title' => $config->meta_title ?? 'Kami Daur - Tentang Kami',
            'description' => $config->meta_description ?? 'Kami Daur adalah platform yang berkomitmen untuk mendukung gerakan daur ulang...',
            'mission' => $config->mission_items ?? [],
            'contact' => [
                'phone' => $config->contact_phone ?? '6281234567890',
                'email' => $config->contact_email ?? 'kami.daur@example.com',
                'address' => $config->contact_address ?? 'Jl. Lingkungan Hijau No. 123, Kota Ramah Lingkungan'
            ],
            'products' => $config->products ?? [],
            'materials' => $config->materials ?? [],
            'impact_stats' => $config->impact_stats ?? [],
            'opening_hours' => $config->opening_hours ?? 'Senin-Sabtu 10:00-20:00',
            'services' => $config->services ?? [],
            'payment_methods' => $config->payment_methods ?? [],
            'shipping_info' => $config->shipping_info ?? 'Gratis pengiriman untuk pembelian di atas Rp 500.000',
            'free_shipping_minimum' => $config->free_shipping_minimum ?? 500000
        ];

        Log::info('KamiDaurController: Home page siap ditampilkan', [
            'has_active_config' => $config->id ? true : false,
            'products_count' => count($data['products']),
            'materials_count' => count($data['materials'])
        ]);

        return view('kami-daur.home', $data);
    }

    /**
     * Upload image ke storage
     */
    private function uploadImage($file, $folder)
    {
        // Generate nama file unik
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Simpan file ke storage/app/public/kami-daur/{folder}
        $path = $file->storeAs("kami-daur/{$folder}", $filename, 'public');

        if (!$path) {
            throw new \Exception('Gagal menyimpan file');
        }

        // Kembalikan URL lengkap
        return Storage::url($path);
    }


    /**
     * Delete image dari storage
     */
    private function deleteImage($path)
    {
        $relativePath = str_replace('/storage/', '', parse_url($path, PHP_URL_PATH));

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    /**
     * Get upload error message
     */
    private function getUploadErrorMessage($error)
    {
        $errors = [
            UPLOAD_ERR_OK => 'Tidak ada error',
            UPLOAD_ERR_INI_SIZE => 'Ukuran file melebihi upload_max_filesize di php.ini',
            UPLOAD_ERR_FORM_SIZE => 'Ukuran file melebihi MAX_FILE_SIZE yang ditentukan',
            UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
            UPLOAD_ERR_EXTENSION => 'File upload dihentikan oleh PHP extension',
        ];

        return $errors[$error] ?? 'Unknown upload error';
    }
}