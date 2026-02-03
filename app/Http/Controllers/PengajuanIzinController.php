<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Repositories\PengajuanIzinSheetRepository;
use Illuminate\Http\Request;
use App\Models\PengajuanIzin;
use App\Exports\PengajuanIzinExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'divisi' => 'required|string',

            'jenis_izin_pilihan' => 'required|string',
            'jenis_izin_lainnya' => 'nullable|string|max:100',

            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_hari' => 'required|integer|min:1',
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

        // simpan file
        if ($request->hasFile('documen_pendukung')) {
            $validated['documen_pendukung'] =
                $request->file('documen_pendukung')
                    ->store('izin_pendukung', 'public');
        }

        DB::transaction(function () use ($validated) {
            // 1️⃣ Simpan ke database
            $izin = PengajuanIzin::create([
                ...$validated,
                'status' => 'Pending',
            ]);

            // 2️⃣ Langsung sync ke Google Sheet
            $repo = new PengajuanIzinSheetRepository();
            $repo->appendSingle($izin);
        });

        return redirect()
            ->route('izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }

    /**
     * Export data pengajuan izin ke Excel
     */
    public function export(Request $request): BinaryFileResponse
    {
        $filename = 'Pengajuan-Izin-' . date('d-m-Y') . '.xlsx';

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

}
