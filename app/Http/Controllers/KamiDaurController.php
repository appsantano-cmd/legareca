<?php
// app/Http/Controllers/KamiDaurController.php

namespace App\Http\Controllers;

use App\Models\KamiDaur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        Log::info('KamiDaurController: Memulai proses store');

        // CEK APAKAH SECTION PRODUK DAN MATERIAL DIAKTIFKAN DARI FORM
        $enableProducts = $request->has('enable_products') ? filter_var($request->enable_products, FILTER_VALIDATE_BOOLEAN) : true;
        $enableMaterials = $request->has('enable_materials') ? filter_var($request->enable_materials, FILTER_VALIDATE_BOOLEAN) : true;

        Log::info('KamiDaurController: Status section', [
            'enable_products' => $enableProducts,
            'enable_materials' => $enableMaterials
        ]);

        // FORCE HAPUS DATA JIKA TIDAK DIAKTIFKAN
        if (!$enableMaterials) {
            $request->request->remove('materials');
            $request->files->remove('materials');
            unset($_POST['materials'], $_FILES['materials']);
            Log::info('KamiDaurController: Data material dihapus karena tidak diaktifkan');
        }

        if (!$enableProducts) {
            $request->request->remove('products');
            $request->files->remove('products');
            unset($_POST['products'], $_FILES['products']);
            Log::info('KamiDaurController: Data produk dihapus karena tidak diaktifkan');
        }

        try {
            $rules = [];

            if ($enableProducts) {
                $rules['products'] = 'required|array|min:1';
                $rules['products.*.name'] = 'required|string|max:255';
                $rules['products.*.price'] = 'nullable|numeric';
                $rules['products.*.description'] = 'nullable|string';
                $rules['products.*.image'] = 'nullable|string';
                $rules['products.*.image_file'] = 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480';
                $rules['products.*.features'] = 'nullable|array';
                $rules['products.*.is_new'] = 'nullable|boolean';
                $rules['products.*.is_bestseller'] = 'nullable|boolean';
            }

            if ($enableMaterials) {
                $rules['materials'] = 'required|array|min:1';
                $rules['materials.*.name'] = 'required|string|max:255';
                $rules['materials.*.description'] = 'nullable|string';
                $rules['materials.*.image'] = 'nullable|string';
                $rules['materials.*.image_file'] = 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480';
                $rules['materials.*.info'] = 'nullable|string';
            }

            $validated = $request->validate($rules);
            Log::info('KamiDaurController: Validasi berhasil');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('KamiDaurController: Validasi gagal', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Proses upload gambar produk
        if ($enableProducts && $request->has('products')) {
            foreach ($validated['products'] as $key => $product) {
                if ($request->hasFile("products.{$key}.image_file")) {
                    try {
                        $file = $request->file("products.{$key}.image_file");
                        if (!$file->isValid()) {
                            throw new \Exception('File tidak valid: ' . $this->getUploadErrorMessage($file->getError()));
                        }
                        $validated['products'][$key]['image'] = $this->uploadImage($file, 'products');
                        Log::info('KamiDaurController: Upload file produk berhasil');
                    } catch (\Exception $e) {
                        Log::error('KamiDaurController: Gagal upload file produk', ['error' => $e->getMessage()]);
                        return redirect()->back()->with('error', 'Gagal upload gambar produk: ' . $e->getMessage())->withInput();
                    }
                }
                unset($validated['products'][$key]['image_file']);
            }
        }

        // Proses upload gambar material
        if ($enableMaterials && $request->has('materials')) {
            foreach ($validated['materials'] as $key => $material) {
                if ($request->hasFile("materials.{$key}.image_file")) {
                    try {
                        $file = $request->file("materials.{$key}.image_file");
                        if (!$file->isValid()) {
                            throw new \Exception('File tidak valid: ' . $this->getUploadErrorMessage($file->getError()));
                        }
                        $validated['materials'][$key]['image'] = $this->uploadImage($file, 'materials');
                        Log::info('KamiDaurController: Upload file material berhasil');
                    } catch (\Exception $e) {
                        Log::error('KamiDaurController: Gagal upload file material', ['error' => $e->getMessage()]);
                        return redirect()->back()->with('error', 'Gagal upload gambar material: ' . $e->getMessage())->withInput();
                    }
                }
                unset($validated['materials'][$key]['image_file']);
            }
        }

        try {
            // ============ PERBAIKAN: SET is_active = 1 ============
            // Set is_active menjadi true (1) untuk data baru
            $validated['is_active'] = true;
            
            $kamiDaur = KamiDaur::create($validated);
            Log::info('KamiDaurController: Data berhasil disimpan dengan is_active = 1', ['id' => $kamiDaur->id]);
            
        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal menyimpan ke database', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('kami-daur.index')->with('success', 'Kami Daur configuration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Menampilkan detail', ['id' => $kamiDaur->id]);
        return view('kami-daur.show', compact('kamiDaur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Mengakses halaman edit', ['id' => $kamiDaur->id]);
        return view('kami-daur.edit', compact('kamiDaur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Memulai proses update', ['id' => $kamiDaur->id]);

        try {
            $validated = $request->validate([
                'products' => 'nullable|array',
                'products.*.name' => 'nullable|string|max:255',
                'products.*.price' => 'nullable|numeric',
                'products.*.description' => 'nullable|string',
                'products.*.image' => 'nullable|string',
                'products.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480',
                'products.*.features' => 'nullable|array',
                'products.*.is_new' => 'nullable|boolean',
                'products.*.is_bestseller' => 'nullable|boolean',
                'materials' => 'nullable|array',
                'materials.*.name' => 'nullable|string|max:255',
                'materials.*.description' => 'nullable|string',
                'materials.*.image' => 'nullable|string',
                'materials.*.image_file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:20480',
                'materials.*.info' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            Log::info('KamiDaurController: Validasi update berhasil', ['id' => $kamiDaur->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('KamiDaurController: Validasi update gagal', ['id' => $kamiDaur->id, 'errors' => $e->errors()]);
            throw $e;
        }

        try {
            if ($request->has('products')) {
                foreach ($validated['products'] as $key => $product) {
                    if ($request->hasFile("products.{$key}.image_file")) {
                        if (isset($kamiDaur->products[$key]['image']) && $kamiDaur->products[$key]['image']) {
                            $this->deleteImage($kamiDaur->products[$key]['image']);
                        }
                        $file = $request->file("products.{$key}.image_file");
                        $validated['products'][$key]['image'] = $this->uploadImage($file, 'products');
                    }
                    unset($validated['products'][$key]['image_file']);
                }
            }

            if ($request->has('materials')) {
                foreach ($validated['materials'] as $key => $material) {
                    if ($request->hasFile("materials.{$key}.image_file")) {
                        if (isset($kamiDaur->materials[$key]['image']) && $kamiDaur->materials[$key]['image']) {
                            $this->deleteImage($kamiDaur->materials[$key]['image']);
                        }
                        $file = $request->file("materials.{$key}.image_file");
                        $validated['materials'][$key]['image'] = $this->uploadImage($file, 'materials');
                    }
                    unset($validated['materials'][$key]['image_file']);
                }
            }
        } catch (\Exception $e) {
            Log::error('KamiDaurController: Error saat proses update file', ['id' => $kamiDaur->id, 'error' => $e->getMessage()]);
            throw $e;
        }

        try {
            if ($request->has('is_active') && $request->is_active && !$kamiDaur->is_active) {
                KamiDaur::where('is_active', true)->update(['is_active' => false]);
            }
            $kamiDaur->update($validated);
            Log::info('KamiDaurController: Update database berhasil', ['id' => $kamiDaur->id]);
        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal update database', ['id' => $kamiDaur->id, 'error' => $e->getMessage()]);
            throw $e;
        }

        return redirect()->route('kami-daur.index')->with('success', 'Kami Daur configuration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KamiDaur $kamiDaur)
    {
        Log::info('KamiDaurController: Memulai proses delete', ['id' => $kamiDaur->id]);

        try {
            if ($kamiDaur->products) {
                foreach ($kamiDaur->products as $product) {
                    if (isset($product['image']) && $product['image']) {
                        $this->deleteImage($product['image']);
                    }
                }
            }

            if ($kamiDaur->materials) {
                foreach ($kamiDaur->materials as $material) {
                    if (isset($material['image']) && $material['image']) {
                        $this->deleteImage($material['image']);
                    }
                }
            }

            $kamiDaur->delete();
            Log::info('KamiDaurController: Delete berhasil', ['id' => $kamiDaur->id]);
        } catch (\Exception $e) {
            Log::error('KamiDaurController: Gagal delete', ['id' => $kamiDaur->id, 'error' => $e->getMessage()]);
            throw $e;
        }

        return redirect()->route('kami-daur.index')->with('success', 'Kami Daur configuration deleted successfully.');
    }

    /**
     * Menampilkan halaman Kami Daur - Menggabungkan semua produk dan material dari semua config active
     */
    public function home()
    {
        Log::info('KamiDaurController: Mengakses halaman home');
        
        // Ambil semua konfigurasi yang active
        $activeConfigs = KamiDaur::where('is_active', true)->orderBy('created_at', 'desc')->get();
        
        Log::info('KamiDaurController: Menemukan ' . $activeConfigs->count() . ' konfigurasi active');
        
        // Array untuk menampung semua produk dan material
        $allProducts = [];
        $allMaterials = [];
        
        // Jika tidak ada config active, langsung kirim array kosong
        if ($activeConfigs->isEmpty()) {
            Log::info('KamiDaurController: Tidak ada config active, mengirim array kosong');
            return view('kami-daur.home', [
                'products' => [],
                'materials' => []
            ]);
        }
        
        // Loop melalui setiap config active
        foreach ($activeConfigs as $config) {
            Log::info('KamiDaurController: Memproses config ID: ' . $config->id);
            
            // CEK DAN GABUNGKAN PRODUK
            if (isset($config->products) && is_array($config->products)) {
                Log::info('KamiDaurController: Config ID ' . $config->id . ' memiliki ' . count($config->products) . ' produk');
                
                foreach ($config->products as $product) {
                    // Pastikan produk memiliki nama (valid)
                    if (isset($product['name']) && !empty($product['name'])) {
                        // Cek duplikasi berdasarkan kombinasi nama
                        $exists = false;
                        foreach ($allProducts as $existingProduct) {
                            if ($existingProduct['name'] === $product['name']) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if (!$exists) {
                            $allProducts[] = $product;
                            Log::info('KamiDaurController: Menambahkan produk: ' . $product['name']);
                        }
                    }
                }
            }
            
            // CEK DAN GABUNGKAN MATERIAL
            if (isset($config->materials) && is_array($config->materials)) {
                Log::info('KamiDaurController: Config ID ' . $config->id . ' memiliki ' . count($config->materials) . ' material');
                
                foreach ($config->materials as $material) {
                    // Pastikan material memiliki nama (valid)
                    if (isset($material['name']) && !empty($material['name'])) {
                        // Cek duplikasi
                        $exists = false;
                        foreach ($allMaterials as $existingMaterial) {
                            if ($existingMaterial['name'] === $material['name']) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if (!$exists) {
                            $allMaterials[] = $material;
                            Log::info('KamiDaurController: Menambahkan material: ' . $material['name']);
                        }
                    }
                }
            }
        }
        
        // Batasi jumlah produk dan material
        if (count($allProducts) > 9) {
            $allProducts = array_slice($allProducts, 0, 9);
        }
        
        if (count($allMaterials) > 6) {
            $allMaterials = array_slice($allMaterials, 0, 6);
        }
        
        Log::info('KamiDaurController: Total produk setelah digabung: ' . count($allProducts));
        Log::info('KamiDaurController: Total material setelah digabung: ' . count($allMaterials));
        
        $data = [
            'products' => $allProducts,
            'materials' => $allMaterials
        ];
        
        return view('kami-daur.home', $data);
    }

    /**
     * Upload image ke storage
     */
    private function uploadImage($file, $folder)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("kami-daur/{$folder}", $filename, 'public');

        if (!$path) {
            throw new \Exception('Gagal menyimpan file');
        }

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