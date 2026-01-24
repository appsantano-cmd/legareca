<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InitStokGudangSeeder extends Seeder
{
    public function run()
    {
        // Data untuk bulan Januari 2026
        $dataJanuari = [
            [
                'kode_barang' => 'MAT-001',
                'nama_barang' => 'Besi Beton 10mm',
                'satuan' => 'batang',
                'stok_awal' => 100.00,
                'stok_masuk' => 50.00,
                'stok_keluar' => 30.00,
                'stok_akhir' => 120.00,
                'bulan' => 1,  // Januari
                'tahun' => 2026,
                'is_rollover' => false,
                'keterangan' => 'Stok awal tahun',
                'created_at' => Carbon::create(2026, 1, 1),
                'updated_at' => Carbon::create(2026, 1, 31)
            ],
            [
                'kode_barang' => 'MAT-002',
                'nama_barang' => 'Semen Portland',
                'satuan' => 'zak',
                'stok_awal' => 200.00,
                'stok_masuk' => 100.00,
                'stok_keluar' => 80.00,
                'stok_akhir' => 220.00,
                'bulan' => 1,
                'tahun' => 2026,
                'is_rollover' => false,
                'keterangan' => 'Semen grade A',
                'created_at' => Carbon::create(2026, 1, 1),
                'updated_at' => Carbon::create(2026, 1, 31)
            ],
            [
                'kode_barang' => 'MAT-003',
                'nama_barang' => 'Cat Tembok Putih',
                'satuan' => 'kaleng',
                'stok_awal' => 50.00,
                'stok_masuk' => 20.00,
                'stok_keluar' => 15.00,
                'stok_akhir' => 55.00,
                'bulan' => 1,
                'tahun' => 2026,
                'is_rollover' => false,
                'keterangan' => 'Cat interior',
                'created_at' => Carbon::create(2026, 1, 1),
                'updated_at' => Carbon::create(2026, 1, 31)
            ],
            [
                'kode_barang' => 'MAT-004',
                'nama_barang' => 'Paku 3 inch',
                'satuan' => 'kg',
                'stok_awal' => 30.00,
                'stok_masuk' => 10.00,
                'stok_keluar' => 5.00,
                'stok_akhir' => 35.00,
                'bulan' => 1,
                'tahun' => 2026,
                'is_rollover' => false,
                'keterangan' => 'Paku bangunan',
                'created_at' => Carbon::create(2026, 1, 1),
                'updated_at' => Carbon::create(2026, 1, 31)
            ],
            [
                'kode_barang' => 'MAT-005',
                'nama_barang' => 'Keramik 40x40',
                'satuan' => 'box',
                'stok_awal' => 80.00,
                'stok_masuk' => 40.00,
                'stok_keluar' => 25.00,
                'stok_akhir' => 95.00,
                'bulan' => 1,
                'tahun' => 2026,
                'is_rollover' => false,
                'keterangan' => 'Keramik lantai',
                'created_at' => Carbon::create(2026, 1, 1),
                'updated_at' => Carbon::create(2026, 1, 31)
            ]
        ];

        // Insert data
        DB::table('stok_gudang')->insert($dataJanuari);

        $this->command->info('✅ Data stok gudang untuk Januari 2026 berhasil dibuat!');
        $this->command->info('📊 Total: 5 barang');
    }
}