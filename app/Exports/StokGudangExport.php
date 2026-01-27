<?php

namespace App\Exports;

use App\Models\StokGudang;
use App\Models\StokTransaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokGudangExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct(Carbon $startDate, Carbon $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return StokGudang::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Satuan',
            'Stok Awal',
            'Stok Masuk',
            'Stok Keluar',
            'Stok Akhir',
            'Bulan',
            'Tahun',
            'Keterangan',
            'Tanggal'
        ];
    }

    public function map($stok): array
    {
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $lastTransaction = $stok->transactions()
            ->orderBy('tanggal', 'desc')
            ->first();

        return [
            $stok->kode_barang,
            $stok->nama_barang,
            $stok->satuan,
            number_format($stok->stok_awal, 2),
            number_format($stok->stok_masuk, 2),
            number_format($stok->stok_keluar, 2),
            number_format($stok->stok_akhir, 2),
            $bulanList[$stok->bulan] ?? $stok->bulan,
            $stok->tahun,
            $stok->keterangan ?? '-',
            $lastTransaction
            ? $lastTransaction->tanggal->format('F-j-Y')
            : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:K' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
            'D:G' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ]
            ]
        ];
    }
}