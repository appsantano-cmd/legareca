<?php

namespace App\Console\Commands;

use App\Models\PengajuanIzin;
use App\Repositories\PengajuanIzinSheetRepository;
use Illuminate\Console\Command;

class SyncApprovalFromSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-approval-from-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   

public function handle()
{
    $this->info('🔄 Sync approval dari Google Sheet...');

    $repo = new PengajuanIzinSheetRepository();
    $rows = $repo->fetchApprovalStatuses();

    foreach ($rows as $row) {
        $izin = PengajuanIzin::find($row['id']);

        if (!$izin) {
            continue;
        }

        if ($izin->status !== $row['status']) {
            $izin->update([
                'status' => $row['status'],
            ]);

            $this->line(
                "✔ ID {$izin->id} diupdate ke {$row['status']}"
            );
        }
    }

    $this->info('✅ Sync approval selesai');
}

}
