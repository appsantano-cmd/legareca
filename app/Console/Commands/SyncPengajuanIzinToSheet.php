<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PengajuanIzin;
use App\Repositories\PengajuanIzinSheetRepository;

class SyncPengajuanIzinToSheet extends Command
{
    protected $signature = 'sync:izin-sheet';
    protected $description = 'Sync data pengajuan izin dari database ke Google Sheet';

    public function handle()
    {
        $this->info('⏳ Sync pengajuan izin dimulai...');

        $repo = new PengajuanIzinSheetRepository();

        // 1. Pastikan sheet ada
        $repo->ensureSheetExists();

        // 2. Ambil data DB
        $izin = PengajuanIzin::orderBy('created_at')->get();

        if ($izin->isEmpty()) {
            $this->warn('⚠️ Tidak ada data pengajuan izin.');
            return;
        }

        // 3. Insert ke Google Sheet
        $repo->syncFromDatabase($izin);

        $this->info('✅ Sync pengajuan izin selesai.');
    }
}
