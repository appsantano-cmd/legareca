<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PengajuanIzin;
use App\Mail\PengajuanIzinNotification;
use App\Mail\StatusUpdateNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengajuanIzinExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Illuminate\Support\Facades\Storage;
use App\Repositories\PengajuanIzinSheetRepository;

class PengajuanIzinController extends Controller
{
    /**
     * Tampilkan daftar pengajuan izin
     */
    public function index(Request $request)
    {
        $query = PengajuanIzin::query();

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('jenis_izin', 'like', "%{$request->search}%")
                    ->orWhere('divisi', 'like', "%{$request->search}%");
            });
        }

        // Filter tanggal mulai
        if ($request->start_date) {
            $query->whereDate('tanggal_mulai', '>=', $request->start_date);
        }

        // Filter tanggal selesai
        if ($request->end_date) {
            $query->whereDate('tanggal_selesai', '<=', $request->end_date);
        }

        // Statistics
        $stats = [
            'total' => PengajuanIzin::count(),
            'pending' => PengajuanIzin::where('status', 'Pending')->count(),
            'approved' => PengajuanIzin::where('status', 'Disetujui')->count(),
            'rejected' => PengajuanIzin::where('status', 'Ditolak')->count(),
        ];

        // Sorting
        $query->latest();

        // Pagination
        $izin = $query->paginate(10)->withQueryString();

        return view('form_pengajuan_izin.pages.index', compact('izin', 'stats'));
    }

    /**
     * Tampilkan form pengajuan izin
     */
    public function create()
    {
        return view('form_pengajuan_izin.pages.create');
    }

    /**
     * Simpan data pengajuan izin
     */
    public function store(Request $request)
    {
        // Validasi user login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengajukan izin.');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'divisi' => 'required|string',
            'jenis_izin_pilihan' => 'required|string',
            'jenis_izin_lainnya' => 'nullable|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'konfirmasi' => 'required|accepted',
            'documen_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,heic,heif|max:20480',
        ]);

        // 🔥 LOGIKA FINAL JENIS IZIN
        if ($validated['jenis_izin_pilihan'] === 'Lainnya') {
            if (!$request->filled('jenis_izin_lainnya')) {
                return back()
                    ->withErrors(['jenis_izin_lainnya' => 'Jenis izin lainnya wajib diisi'])
                    ->withInput();
            }

            $validated['jenis_izin'] = $validated['jenis_izin_lainnya'];
        } else {
            $validated['jenis_izin'] = $validated['jenis_izin_pilihan'];
        }

        unset($validated['jenis_izin_pilihan'], $validated['jenis_izin_lainnya']);

        // Hitung jumlah hari otomatis
        $tanggal_mulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggal_selesai = Carbon::parse($validated['tanggal_selesai']);
        $jumlah_hari = $tanggal_mulai->diffInDays($tanggal_selesai) + 1;

        // simpan file
        if ($request->hasFile('documen_pendukung')) {
            $file = $request->file('documen_pendukung');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // ✅ SIMPAN LANGSUNG KE PUBLIC/STORAGE/IZIN_PENDUKUNG
            $uploadPath = public_path('storage/izin_pendukung');

            // Buat folder jika belum ada
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Pindahkan file
            $file->move($uploadPath, $filename);

            // Simpan path ke database
            $validated['documen_pendukung'] = 'storage/izin_pendukung/' . $filename;
        }

        DB::beginTransaction();

        try {
            // 1️⃣ Simpan ke database
            $izin = PengajuanIzin::create([
                'nama' => $user->name,
                'jumlah_hari' => $jumlah_hari,
                ...$validated,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'status' => 'Pending',
            ]);

            // 2️⃣ Kirim email notifikasi ke admin
            $this->sendEmailToAdmin($izin, $user);

            // 3️⃣ Sync ke Google Sheet
            $repo = new \App\Repositories\PengajuanIzinSheetRepository();

            // Pastikan sheet ada dan header benar
            $repo->ensureHeader();

            // Cek dulu apakah ID sudah ada di Google Sheets
            $existingData = $repo->getAllData();
            $existingIds = array_column($existingData, 'id');

            \Log::info('📊 Checking existing IDs in Google Sheets', [
                'new_id' => $izin->id,
                'existing_ids' => $existingIds,
                'exists' => in_array($izin->id, $existingIds)
            ]);

            $googleSheetsSuccess = false;

            if (in_array($izin->id, $existingIds)) {
                \Log::warning('⚠️ ID ' . $izin->id . ' already exists in Google Sheets. Updating instead.');

                // Update existing row - hanya update status karena ini baru dibuat
                $googleSheetsSuccess = $repo->updateStatus(
                    $izin->id,
                    $izin->status,
                    $izin->catatan_admin ?? '',
                    $izin->disetujui_oleh ?? ''
                );
            } else {
                // Append new row
                $googleSheetsSuccess = $repo->appendSingle($izin);
            }

            if (!$googleSheetsSuccess) {
                \Log::warning('Google Sheets sync failed for izin ID: ' . $izin->id);

                // Coba fallback method
                try {
                    \Log::info('🔄 Trying fallback method for Google Sheets...');

                    // Fallback: Update status dengan metode yang lebih sederhana
                    if (
                        $repo->updateStatus(
                            $izin->id,
                            $izin->status,
                            $izin->catatan_admin ?? '',
                            $izin->disetujui_oleh ?? ''
                        )
                    ) {
                        \Log::info('✅ Fallback method succeeded');
                        $googleSheetsSuccess = true;
                    }
                } catch (\Exception $fallbackError) {
                    \Log::error('Fallback also failed: ' . $fallbackError->getMessage());
                }
            }

            DB::commit();

            if ($googleSheetsSuccess) {
                return redirect()
                    ->route('izin.create')
                    ->with('success', 'Pengajuan izin berhasil dikirim. Notifikasi telah dikirim ke admin dan data tersimpan di Google Sheets.');
            } else {
                return redirect()
                    ->route('izin.create')
                    ->with('warning', 'Pengajuan izin berhasil dikirim. Notifikasi telah dikirim ke admin. (Catatan: Data Google Sheets belum tersinkron)');
            }

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error storing izin: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan pengajuan izin: ' . $e->getMessage());
        }
    }

    /**
     * Update status pengajuan izin (untuk admin)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $izin = PengajuanIzin::findOrFail($id);

        // Simpan status lama untuk log
        $oldStatus = $izin->status;

        $izin->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'disetujui_oleh' => $user->name,
            'tanggal_persetujuan' => now(),
        ]);

        // 1️⃣ Kirim email notifikasi ke user
        $this->sendStatusUpdateEmail($izin, $oldStatus);

        // 2️⃣ Update Google Sheets status
        try {
            $repo = new \App\Repositories\PengajuanIzinSheetRepository();

            // Update status di Google Sheet
            $googleSheetsSuccess = $repo->updateStatus(
                $izin->id,
                $izin->status,
                $izin->catatan_admin,
                $izin->disetujui_oleh
            );

            if ($googleSheetsSuccess) {
                \Log::info('✅ Google Sheets status updated for izin ID: ' . $izin->id);
            } else {
                \Log::warning('⚠️ Failed to update Google Sheets for izin ID: ' . $izin->id);
            }

        } catch (\Exception $e) {
            \Log::error('❌ Error updating Google Sheets: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Status pengajuan izin berhasil diperbarui. Notifikasi telah dikirim ke user.');
    }

    /**
     * Action untuk menerima atau menolak dari email admin
     */
    public function actionFromEmail(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'token' => 'required|string',
        ]);

        // Verifikasi token sederhana (bisa ditingkatkan dengan token lebih kompleks)
        $expectedToken = md5($id . env('APP_KEY'));

        if ($request->token !== $expectedToken) {
            abort(403, 'Token tidak valid.');
        }

        $izin = PengajuanIzin::findOrFail($id);

        if ($izin->status !== 'Pending') {
            return redirect()->route('izin.index')
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $status = $request->action === 'approve' ? 'Disetujui' : 'Ditolak';

        // Update status (tanpa perlu login admin)
        $izin->update([
            'status' => $status,
            'disetujui_oleh' => 'Admin (via Email)',
            'tanggal_persetujuan' => now(),
        ]);

        // Kirim email notifikasi ke user
        $this->sendStatusUpdateEmail($izin, 'Pending');

        return redirect()->route('izin.index')
            ->with('success', "Pengajuan izin berhasil {$status}.");
    }

    /**
     * Kirim email notifikasi ke admin
     */
    private function sendEmailToAdmin($izin, $user)
    {
        try {
            $adminEmail = "appsantano@gmail.com";

            // Generate token untuk action dari email
            $actionToken = md5($izin->id . env('APP_KEY'));

            // Cek apakah file pendukung tersedia
            $fileAttached = false;
            $filePath = null;
            $fileName = null;
            $fileMime = null;

            Log::info('📎 [EMAIL IZIN] Cek file pendukung', [
                'izin_id' => $izin->id,
                'documen_pendukung' => $izin->documen_pendukung
            ]);

            if ($izin->documen_pendukung) {
                // ✅ PERBAIKAN: Cek file di public path
                $relativePath = str_replace('storage/', '', $izin->documen_pendukung);
                $publicPath = public_path('storage/izin_pendukung/' . basename($izin->documen_pendukung));

                Log::info('📂 [EMAIL IZIN] Checking file', [
                    'public_path' => $publicPath,
                    'file_exists' => file_exists($publicPath)
                ]);

                if (file_exists($publicPath)) {
                    $fileAttached = true;
                    $filePath = $publicPath;
                    $fileName = basename($publicPath);

                    // Tentukan mime type
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $fileMime = $this->getMimeType($extension);

                    Log::info('✅ [EMAIL IZIN] File siap dilampirkan', [
                        'file_name' => $fileName,
                        'file_mime' => $fileMime,
                        'file_size_mb' => round(filesize($filePath) / 1024 / 1024, 2)
                    ]);
                } else {
                    // Fallback: cek di storage lama untuk file lama
                    $oldPath = storage_path('app/public/' . $izin->documen_pendukung);
                    if (file_exists($oldPath)) {
                        $fileAttached = true;
                        $filePath = $oldPath;
                        $fileName = basename($oldPath);
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $fileMime = $this->getMimeType($extension);

                        Log::info('✅ [EMAIL IZIN] Using old storage file', [
                            'file_path' => $oldPath
                        ]);
                    }
                }
            }

            // Data untuk email
            $mailData = [
                'izin' => $izin,
                'user' => $user,
                'actionToken' => $actionToken,
                'approveUrl' => route('izin.email-action', [
                    'id' => $izin->id,
                    'action' => 'approve',
                    'token' => $actionToken
                ]),
                'rejectUrl' => route('izin.email-action', [
                    'id' => $izin->id,
                    'action' => 'reject',
                    'token' => $actionToken
                ]),
                'fileAttached' => $fileAttached,
                'fileName' => $fileName,
            ];

            // Kirim email dengan attachment jika ada file
            if ($fileAttached && $filePath) {
                Mail::to($adminEmail)->send(new PengajuanIzinNotification($mailData, $filePath, $fileName, $fileMime));
            } else {
                Mail::to($adminEmail)->send(new PengajuanIzinNotification($mailData));
            }

            Log::info('✅ Email notification sent to admin for izin ID: ' . $izin->id . ' | File attached: ' . ($fileAttached ? 'Yes' : 'No'));

        } catch (\Exception $e) {
            Log::error('❌ Failed to send email to admin: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Helper function untuk menentukan mime type
     */
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'heic' => 'image/heic',
            'heif' => 'image/heif',
            'webp' => 'image/webp',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Test email dengan attachment
     */
    public function testEmailAttachment($id)
    {
        try {
            $izin = PengajuanIzin::findOrFail($id);
            $user = Auth::user() ?? $izin->user;

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }

            Log::info('🧪 Testing email attachment for izin ID: ' . $id);

            // Test file attachment
            if ($izin->documen_pendukung) {
                $relativePath = $izin->documen_pendukung;
                $existsInDisk = Storage::disk('public')->exists($relativePath);

                Log::info('🔍 File check:', [
                    'path' => $relativePath,
                    'exists' => $existsInDisk,
                    'storage_path' => Storage::disk('public')->path($relativePath),
                    'real_exists' => file_exists(Storage::disk('public')->path($relativePath))
                ]);

                if ($existsInDisk) {
                    $filePath = Storage::disk('public')->path($relativePath);
                    Log::info('📊 File info:', [
                        'size' => filesize($filePath),
                        'size_mb' => round(filesize($filePath) / 1024 / 1024, 2),
                        'is_readable' => is_readable($filePath)
                    ]);
                }
            }

            // Test send email
            $this->sendEmailToAdmin($izin, $user);

            return response()->json([
                'success' => true,
                'message' => 'Email test dikirim'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Test email error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kirim email notifikasi update status ke user
     */
    private function sendStatusUpdateEmail($izin, $oldStatus)
    {
        try {
            if (!$izin->user_email) {
                \Log::warning('Email user tidak ditemukan untuk pengajuan izin ID: ' . $izin->id);
                return;
            }

            $mailData = [
                'izin' => $izin,
                'oldStatus' => $oldStatus,
            ];

            Mail::to($izin->user_email)->send(new StatusUpdateNotification($mailData));

        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email update status: ' . $e->getMessage());
        }
    }

    /**
     * Export data pengajuan izin ke Excel
     */
    public function export(Request $request): BinaryFileResponse
    {
        $filename = 'Data Pengajuan Izin - ' . date('d F Y') . '.xlsx';

        return Excel::download(
            new PengajuanIzinExport(
                $request->status,
                $request->search,
                $request->start_date,
                $request->end_date
            ),
            $filename
        );
    }

    /**
     * Get detail pengajuan izin (untuk modal)
     */
    public function detail($id)
    {
        try {
            $izin = PengajuanIzin::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $izin->nama,
                    'user_email' => $izin->user_email,
                    'divisi' => $izin->divisi,
                    'jenis_izin' => $izin->jenis_izin,
                    'tanggal_mulai' => $izin->tanggal_mulai,
                    'tanggal_selesai' => $izin->tanggal_selesai,
                    'jumlah_hari' => $izin->jumlah_hari,
                    'nomor_telepon' => $izin->nomor_telepon,
                    'alamat' => $izin->alamat,
                    'keterangan_tambahan' => $izin->keterangan_tambahan,
                    'status' => $izin->status,
                    'catatan_admin' => $izin->catatan_admin,
                    'disetujui_oleh' => $izin->disetujui_oleh,
                    'documen_pendukung' => $izin->documen_pendukung ? asset($izin->documen_pendukung) : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Auto-update Google Sheet setelah status berubah
     */
    private function updateGoogleSheetsStatus($izin)
    {
        try {
            $repo = new \App\Repositories\PengajuanIzinSheetRepository();

            // Update status di Google Sheet
            $success = $repo->updateStatus(
                $izin->id,
                $izin->status,
                $izin->catatan_admin,
                $izin->disetujui_oleh
            );

            if ($success) {
                \Log::info('✅ Google Sheets status updated for izin ID: ' . $izin->id);
            } else {
                \Log::warning('⚠️ Failed to update Google Sheets for izin ID: ' . $izin->id);
            }

        } catch (\Exception $e) {
            \Log::error('❌ Error updating Google Sheets: ' . $e->getMessage());
        }
    }
}