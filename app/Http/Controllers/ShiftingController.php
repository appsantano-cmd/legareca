<?php

namespace App\Http\Controllers;

use App\Models\Shifting;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\TukarShiftExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini

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
    ];

    public function index()
    {
        try {
            $shiftings = Shifting::orderBy('created_at', 'desc')->get();
            return view('shifting.index', compact('shiftings'));
        } catch (\Exception $e) {
            // Fallback ke query builder jika ada error
            $shiftings = \Illuminate\Support\Facades\DB::table('shift_requests')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('shifting.index', compact('shiftings'));
        }
    }

    public function create()
    {
        return view('shifting.create');
    }

    public function submit(Request $request, GoogleSheetsService $sheets)
    {
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
            ['status' => 'pending']
        ));

        // 2️⃣ Pastikan header di Google Sheets selalu sinkron
        $sheets->setHeader(array_values($this->sheetHeaders), 'Tukar Shift!A1');

        // 3️⃣ Build row BERDASARKAN KEY (bukan urutan manual)
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
        ];

        // 4️⃣ Append sesuai urutan header
        $orderedRow = [];
        foreach (array_keys($this->sheetHeaders) as $key) {
            $orderedRow[] = $row[$key] ?? '-';
        }

        $sheets->append($orderedRow, 'Tukar Shift!A2');

        return redirect()
            ->route('shifting.create')
            ->with('success', 'Pengajuan tukar shift berhasil dikirim & tunggu konfirmasi.');
    }

    /**
     * Export data ke Excel
     */
        public function export()
    {
        try {
            // Generate nama file dengan timestamp
            $filename = 'Data Pengajuan Tukar Shift - ' . date('d F Y') . '.xlsx';
            
            return Excel::download(new TukarShiftExport(), $filename);
        } catch (\Exception $e) {
            // Jika ada error, redirect kembali dengan pesan
            return redirect()->route('shifting.index')
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
}
