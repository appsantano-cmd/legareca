<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands akan otomatis di-load dari folder Commands
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Menggunakan Command untuk rollover (lebih baik)
        $schedule->command('stok:rollover')
            ->monthlyOn('last day of this month', '23:59')
            ->timezone('Asia/Jakarta')
            ->before(function () {
                \Log::info('🔄 Memulai scheduled rollover stok...');
            })
            ->after(function () {
                \Log::info('✅ Scheduled rollover stok selesai.');
            })
            ->onSuccess(function () {
                \Log::info('🎉 Rollover berhasil dijalankan otomatis.');
            })
            ->onFailure(function () {
                \Log::error('❌ Rollover otomatis gagal.');
                // Bisa tambahkan notifikasi email di sini
            })
            ->name('stok-gudang-rollover')
            ->description('Rollover stok gudang ke bulan berikutnya');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
