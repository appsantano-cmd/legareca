<?php

namespace App\Http\Controllers;

use App\Models\Shifting;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\TukarShiftExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Mail\TukarShiftNotification;
use App\Mail\TukarShiftStatusUpdateNotification;

class shiftingController extends Controller
{
    /**
     * 🔑 Single source of truth untuk HEADER
     * Jika judul kolom ingin diubah → ubah di sini saja
     */
    private array $sheetHeaders = [
        'id' => 'ID',
        'created_at' => 'Dibuat',
        'nama_karyawan' => 'Nama Lengkap',
        'divisi_jabatan' => 'Divisi/Jabatan',
        'tanggal_shift_asli' => 'Tanggal Shift Asli',
        'jam_shift_asli' => 'Jam Kerja Shift Asli',
        'tanggal_shift_tujuan' => 'Tanggal Shift yang Diinginkan',
        'jam_shift_tujuan' => 'Jam Shift yang Diinginkan',
        'alasan' => 'Alasan Pengajuan',
        'sudah_pengganti' => 'Sudah ada pengganti ?',
        'nama_karyawan_pengganti' => 'Nama Karyawan Pengganti',
        'tanggal_shift_pengganti' => 'Tanggal Shift Pengganti',
        'jam_shift_pengganti' => 'Jam Shift Pengganti',
        'status' => 'Status',
        'user_email' => 'Email Karyawan',
        'catatan_admin' => 'Catatan Admin',
        'disetujui_oleh' => 'Disetujui Oleh',
        'tanggal_persetujuan' => 'Tanggal Persetujuan',
    ];

    /**
     * 🔑 Email admin untuk notifikasi
     */
    private string $adminEmail = "legareca.space@gmail.com";

    public function index(Request $request)
    {
        try {
            $query = Shifting::query();

            // Filter search
            if ($request->has('search') && $request->search) {
                $query->where('nama_karyawan', 'like', '%' . $request->search . '%');
            }

            // Filter status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Sorting
            $query->orderBy('created_at', 'desc');

            // Pagination (opsional, bisa disesuaikan)
            $shiftings = $query->paginate(10)->withQueryString();

            return view('shifting.index', compact('shiftings'));
        } catch (\Exception $e) {
            // Fallback ke query builder jika ada error
            $shiftings = \Illuminate\Support\Facades\DB::table('shift_requests')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('shifting.index', compact('shiftings'));
        }
    }

    public function create()
    {
        return view('shifting.create');
    }

    public function submit(Request $request, GoogleSheetsService $sheets)
    {
        // Validasi user login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengajukan tukar shift.');
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required|string|max:255',
            'divisi_jabatan' => 'required|string|max:255',
            'tanggal_shift_asli' => 'required|date',
            'jam_shift_asli' => 'required',
            'tanggal_shift_tujuan' => 'required|date|after_or_equal:tanggal_shift_asli',
            'jam_shift_tujuan' => 'required',
            'alasan' => 'required|string|min:10',
            'sudah_pengganti' => 'required|in:ya,belum',
            'nama_karyawan_pengganti' => 'nullable|required_if:sudah_pengganti,ya|string|max:255',
            'tanggal_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya|date',
            'jam_shift_pengganti' => 'nullable|required_if:sudah_pengganti,ya',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // 1️⃣ Simpan ke database
            $shifting = shifting::create(array_merge(
                $request->only([
                    'nama_karyawan',
                    'divisi_jabatan',
                    'tanggal_shift_asli',
                    'jam_shift_asli',
                    'tanggal_shift_tujuan',
                    'jam_shift_tujuan',
                    'alasan',
                    'sudah_pengganti',
                    'nama_karyawan_pengganti',
                    'tanggal_shift_pengganti',
                    'jam_shift_pengganti',
                ]),
                [
                    'status' => 'pending',
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                ]
            ));

            // 2️⃣ Kirim email notifikasi ke admin
            $this->sendEmailToAdmin($shifting, $user);

            // 3️⃣ Simpan ke Google Sheets
            $this->saveToGoogleSheets($shifting, $sheets);

            DB::commit();

            return redirect()
                ->route('shifting.create')
                ->with('success', 'Pengajuan tukar shift berhasil dikirim. Notifikasi telah dikirim ke admin.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error submitting shift request: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim pengajuan tukar shift: ' . $e->getMessage());
        }
    }

    /**
     * Update status pengajuan shift (untuk admin)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $shifting = Shifting::findOrFail($id);

        // Simpan status lama untuk log
        $oldStatus = $shifting->status;

        $shifting->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'disetujui_oleh' => $user->name,
            'tanggal_persetujuan' => now(),
        ]);

        // 1️⃣ Kirim email notifikasi ke user
        $this->sendStatusUpdateEmail($shifting, $oldStatus);

        // 2️⃣ Update Google Sheets status
        try {
            $this->updateGoogleSheetsStatus($shifting);
        } catch (\Exception $e) {
            Log::error('Error updating Google Sheets status: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Status pengajuan tukar shift berhasil diperbarui. Notifikasi telah dikirim ke user.');
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

        // Verifikasi token
        $expectedToken = md5($id . env('APP_KEY'));

        if ($request->token !== $expectedToken) {
            abort(403, 'Token tidak valid.');
        }

        $shifting = Shifting::findOrFail($id);

        if ($shifting->status !== 'pending') {
            return redirect()->route('shifting.index')
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $status = $request->action === 'approve' ? 'disetujui' : 'ditolak';

        // Update status (tanpa perlu login admin)
        $shifting->update([
            'status' => $status,
            'disetujui_oleh' => 'Admin (via Email)',
            'tanggal_persetujuan' => now(),
        ]);

        // Kirim email notifikasi ke user
        $this->sendStatusUpdateEmail($shifting, 'pending');

        return redirect()->route('shifting.index')
            ->with('success', "Pengajuan tukar shift berhasil {$status}.");
    }

    /**
     * Kirim email notifikasi ke admin
     */
    private function sendEmailToAdmin($shifting, $user)
    {
        try {
            // Generate token untuk action dari email
            $actionToken = md5($shifting->id . env('APP_KEY'));

            // Data untuk email
            $mailData = [
                'shifting' => $shifting,
                'user' => $user,
                'actionToken' => $actionToken,
                'approveUrl' => route('shifting.email-action', [
                    'id' => $shifting->id,
                    'action' => 'approve',
                    'token' => $actionToken
                ]),
                'rejectUrl' => route('shifting.email-action', [
                    'id' => $shifting->id,
                    'action' => 'reject',
                    'token' => $actionToken
                ]),
            ];

            Mail::to($this->adminEmail)->send(new TukarShiftNotification($mailData));

            Log::info('✅ Email notification sent to admin for shift request ID: ' . $shifting->id);

        } catch (\Exception $e) {
            Log::error('❌ Failed to send email to admin: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Kirim email notifikasi update status ke user
     */
    private function sendStatusUpdateEmail($shifting, $oldStatus)
    {
        try {
            if (!$shifting->user_email) {
                Log::warning('Email user tidak ditemukan untuk pengajuan shift ID: ' . $shifting->id);
                return;
            }

            $mailData = [
                'shifting' => $shifting,
                'oldStatus' => $oldStatus,
            ];

            Mail::to($shifting->user_email)->send(new TukarShiftStatusUpdateNotification($mailData));

            Log::info('✅ Status update email sent to user for shift request ID: ' . $shifting->id);

        } catch (\Exception $e) {
            Log::error('❌ Failed to send status update email: ' . $e->getMessage());
        }
    }

    /**
     * Simpan data ke Google Sheets
     */
    private function saveToGoogleSheets($shifting, $sheets): void
    {
        try {
            // Pastikan header di Google Sheets selalu sinkron
            $sheets->setHeader(array_values($this->sheetHeaders), 'Tukar Shift!A1');

            // Build row BERDASARKAN KEY (bukan urutan manual)
            $row = [
                'id' => $shifting->id,
                'created_at' => $shifting->created_at
                    ->setTimezone('Asia/Jakarta')
                    ->format('Y-m-d H:i:s'),
                'nama_karyawan' => $shifting->nama_karyawan,
                'divisi_jabatan' => $shifting->divisi_jabatan,
                'tanggal_shift_asli' => optional($shifting->tanggal_shift_asli)->format('Y-m-d'),
                'jam_shift_asli' => $shifting->jam_shift_asli,
                'tanggal_shift_tujuan' => optional($shifting->tanggal_shift_tujuan)->format('Y-m-d'),
                'jam_shift_tujuan' => $shifting->jam_shift_tujuan,
                'alasan' => $shifting->alasan,
                'sudah_pengganti' => $shifting->sudah_pengganti,
                'nama_karyawan_pengganti' => $shifting->nama_karyawan_pengganti ?? '-',
                'tanggal_shift_pengganti' => optional($shifting->tanggal_shift_pengganti)->format('Y-m-d') ?? '-',
                'jam_shift_pengganti' => $shifting->jam_shift_pengganti ?? '-',
                'status' => $shifting->status,
                'user_email' => $shifting->user_email ?? '',
                'catatan_admin' => $shifting->catatan_admin ?? '',
                'disetujui_oleh' => $shifting->disetujui_oleh ?? '',
                'tanggal_persetujuan' => optional($shifting->tanggal_persetujuan)->format('Y-m-d H:i:s') ?? '',
            ];

            // Append sesuai urutan header
            $orderedRow = [];
            foreach (array_keys($this->sheetHeaders) as $key) {
                $orderedRow[] = $row[$key] ?? '-';
            }

            $sheets->append($orderedRow, 'Tukar Shift!A2');

            Log::info('✅ Data saved to Google Sheets for shift request ID: ' . $shifting->id);

        } catch (\Exception $e) {
            Log::error('❌ Error saving to Google Sheets: ' . $e->getMessage());
            throw $e; // Rethrow untuk ditangani di method submit
        }
    }

    /**
     * Update status di Google Sheets
     */
    private function updateGoogleSheetsStatus($shifting): void
    {
        try {
            // Update status di Google Sheets (kolom N, O, P, Q untuk status, catatan_admin, disetujui_oleh, tanggal_persetujuan)
            $sheets = new GoogleSheetsService();

            // Cari row berdasarkan ID
            $rowNumber = $this->findRowNumberInGoogleSheets($shifting->id, $sheets);

            if ($rowNumber === null) {
                Log::warning('Row not found in Google Sheets for shift ID: ' . $shifting->id);
                return;
            }

            // Update kolom status, catatan_admin, disetujui_oleh, tanggal_persetujuan
            // Kolom: N (14) = Status, O (15) = Catatan Admin, P (16) = Disetujui Oleh, Q (17) = Tanggal Persetujuan
            $updateData = [
                $shifting->status,
                $shifting->user_email,
                $shifting->catatan_admin ?? '',
                $shifting->disetujui_oleh ?? '',
                $shifting->tanggal_persetujuan ? $shifting->tanggal_persetujuan->format('d-m-Y H:i:s') : '',
            ];

            $range = "Tukar Shift!N{$rowNumber}:R{$rowNumber}";

            $body = new \Google\Service\Sheets\ValueRange([
                'values' => [$updateData]
            ]);

            $params = [
                'valueInputOption' => 'USER_ENTERED'
            ];

            $sheets->raw()->spreadsheets_values->update(
                $sheets->getSpreadsheetId(),
                $range,
                $body,
                $params
            );

            Log::info('✅ Google Sheets status updated for shift ID: ' . $shifting->id);

        } catch (\Exception $e) {
            Log::error('❌ Error updating Google Sheets status: ' . $e->getMessage());
        }
    }

    /**
     * Cari nomor row di Google Sheets berdasarkan ID
     */
    private function findRowNumberInGoogleSheets($id, $sheets): ?int
    {
        try {
            $range = 'Tukar Shift!A2:A';
            $values = $sheets->getValues($range);

            if (empty($values)) {
                return null;
            }

            foreach ($values as $index => $row) {
                if (isset($row[0]) && (int) $row[0] === (int) $id) {
                    // +2 karena index dimulai dari 0 dan header di row 1
                    return $index + 2;
                }
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Error finding row in Google Sheets: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Export data ke Excel dengan filter tanggal
     */
    public function export(Request $request)
    {
        try {
            // Validasi input tanggal (opsional)
            $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Generate nama file dengan timestamp
            $filename = 'Data Pengajuan Tukar Shift';
            
            if ($startDate && $endDate) {
                $filename .= ' (' . Carbon::parse($startDate)->format('d-m-Y') . ' s.d ' . Carbon::parse($endDate)->format('d-m-Y') . ')';
            } elseif ($startDate) {
                $filename .= ' (dari ' . Carbon::parse($startDate)->format('d-m-Y') . ')';
            } elseif ($endDate) {
                $filename .= ' (sampai ' . Carbon::parse($endDate)->format('d-m-Y') . ')';
            } else {
                $filename .= ' - ' . date('d F Y');
            }
            
            $filename .= '.xlsx';

            return Excel::download(new TukarShiftExport($startDate, $endDate), $filename);
        } catch (\Exception $e) {
            // Jika ada error, redirect kembali dengan pesan
            return redirect()->route('shifting.index')
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Get detail pengajuan shift (untuk modal)
     */
    public function detail($id)
    {
        try {
            $shifting = Shifting::findOrFail($id);

            return response()->json([
                'success' => true,
                'nama_karyawan' => $shifting->nama_karyawan,
                'user_email' => $shifting->user_email,
                'divisi_jabatan' => $shifting->divisi_jabatan,
                'tanggal_shift_asli' => $shifting->tanggal_shift_asli,
                'jam_shift_asli' => $shifting->jam_shift_asli,
                'tanggal_shift_tujuan' => $shifting->tanggal_shift_tujuan,
                'jam_shift_tujuan' => $shifting->jam_shift_tujuan,
                'alasan' => $shifting->alasan,
                'sudah_pengganti' => $shifting->sudah_pengganti,
                'nama_karyawan_pengganti' => $shifting->nama_karyawan_pengganti,
                'tanggal_shift_pengganti' => $shifting->tanggal_shift_pengganti,
                'jam_shift_pengganti' => $shifting->jam_shift_pengganti,
                'status' => $shifting->status,
                'catatan_admin' => $shifting->catatan_admin,
                'disetujui_oleh' => $shifting->disetujui_oleh,
                'tanggal_persetujuan' => $shifting->tanggal_persetujuan,
                'created_at' => $shifting->created_at,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}