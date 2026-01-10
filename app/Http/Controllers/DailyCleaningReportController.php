<?php

namespace App\Http\Controllers;

use App\Models\DailyCleaningReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyCleaningReportController extends Controller
{
    // Step 1: Form pertama
    public function create()
    {
        return view('cleaning-report.form-step1');
    }

    // Store data step 1 dan redirect ke step 2
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'department' => 'required|string|in:Kitchen,Bar,Marcom,Server,Cleaning Staff',
            // HAPUS validasi untuk work_completed
        ]);

        // Simpan data sementara
        $report = DailyCleaningReport::create([
            'nama' => $validated['nama'],
            'departments' => json_encode([$validated['department']]), // Simpan sebagai array dengan 1 item
            'work_completed' => null, // Kosongkan karena tidak ada
            'report_date' => now(),
            'status' => 'step1',
        ]);

        // Redirect ke step 2
        return redirect()->route('cleaning-report.step2', $report->id);
    }

    // Step 2: Form kedua
    public function showStep2($id)
    {
        $report = DailyCleaningReport::findOrFail($id);
        return view('cleaning-report.form-step2', compact('report'));
    }

    // Store data step 2 (lengkapi data)
    public function storeStep2(Request $request, $id)
    {
        $validated = $request->validate([
            'membership_datetime' => 'required|date',
            'toilet_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $report = DailyCleaningReport::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('toilet_photo')) {
            $path = $request->file('toilet_photo')->store('toilet-photos', 'public');
            $validated['toilet_photo_path'] = $path;
        }

        // Update report dengan data step 2
        $report->update([
            'membership_datetime' => $validated['membership_datetime'],
            'toilet_photo_path' => $validated['toilet_photo_path'],
            'status' => 'completed',
        ]);

        return redirect()->route('cleaning-report.complete', $report->id)
            ->with('success', 'Laporan berhasil diselesaikan!');
    }

    // Halaman selesai
    public function complete($id)
    {
        $report = DailyCleaningReport::findOrFail($id);
        return view('cleaning-report.complete', compact('report'));
    }

    public function index()
    {
        $reports = DailyCleaningReport::latest()->get();
        return view('cleaning-report.index', compact('reports'));
    }
}
