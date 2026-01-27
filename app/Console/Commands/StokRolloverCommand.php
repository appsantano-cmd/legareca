<?php

namespace App\Console\Commands;

use App\Models\StokGudang;
use Illuminate\Console\Command;

class StokRolloverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stok:rollover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan rollover stok gudang ke bulan berikutnya';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔄 Memulai proses rollover stok gudang...');
        $this->line('📅 Tanggal: ' . now()->format('d F Y H:i:s'));
        
        // Cek apakah hari ini akhir bulan
        $today = now();
        $isLastDayOfMonth = $today->isLastOfMonth();
        
        if (!$isLastDayOfMonth) {
            $lastDay = $today->copy()->endOfMonth();
            $this->warn('⚠️  Hari ini BUKAN akhir bulan.');
            $this->line('   Rollover hanya dijalankan di akhir bulan.');
            $this->line('   Akhir bulan: ' . $lastDay->format('d F Y'));
            $this->line('   Anda tetap bisa menjalankan manual dengan command ini.');
            
            if (!$this->confirm('Lanjutkan rollover manual?')) {
                $this->info('❌ Rollover dibatalkan.');
                return Command::FAILURE;
            }
        }
        
        $this->info('⚙️  Memproses rollover...');
        
        try {
            $result = StokGudang::rolloverToNextMonth();
            
            if ($result['success']) {
                $this->newLine();
                $this->info('✅ ' . $result['message']);
                $this->info('📦 Total barang: ' . count($result['data']));
                
                // Tampilkan dalam tabel
                $headers = ['Nama Barang', 'Stok Akhir', 'Dari Periode', 'Ke Periode'];
                $rows = [];
                
                foreach ($result['data'] as $item) {
                    $rows[] = [
                        $item['barang'],
                        number_format($item['stok'], 2),
                        $item['from'],
                        $item['to']
                    ];
                }
                
                if (count($rows) > 0) {
                    $this->table($headers, $rows);
                }
                
                // Log ke file
                \Log::info('Rollover manual berhasil: ' . $result['message']);
                
                $this->info('🎉 Rollover selesai!');
                return Command::SUCCESS;
                
            } else {
                $this->newLine();
                $this->error('❌ ' . $result['message']);
                \Log::error('Rollover manual gagal: ' . $result['message']);
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('💥 Error: ' . $e->getMessage());
            \Log::error('Rollover error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}