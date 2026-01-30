<?php

namespace App\Exports;

use App\Models\StokGudang;
use App\Models\MasterStokGudang;
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
    protected $exportType;

    public function __construct($startDate = null, $endDate = null, $exportType = 'detail')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->exportType = $exportType;
    }

    public function collection()
    {
        if ($this->exportType === 'master') {
            return MasterStokGudang::orderBy('kode_barang', 'asc')->get();
        }

        // Pastikan tanggal valid
        if (!$this->startDate || !$this->endDate) {
            // Default ke bulan ini jika tidak ada tanggal
            $startMonth = Carbon::now()->month();
            $startYear = Carbon::now()->year();

            return StokGudang::whereBetween('bulan', $startMonth)
                ->where('tahun', $startYear)
                ->orderBy('kode_barang', 'asc')
                ->get();
        }

        // Parse tanggal mulai dan selesai
        $startCarbon = Carbon::parse($this->startDate);
        $endCarbon = Carbon::parse($this->endDate);

        // Ambil bulan dan tahun dari rentang tanggal
        $startMonth = $startCarbon->month;
        $startYear = $startCarbon->year;
        $endMonth = $endCarbon->month;
        $endYear = $endCarbon->year;

        \Log::info('Export Filter:', [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'start_month' => $startMonth,
            'start_year' => $startYear,
            'end_month' => $endMonth,
            'end_year' => $endYear
        ]);

        // Query untuk rentang bulan dan tahun
        $query = StokGudang::query();

        // Jika rentang dalam tahun yang sama
        if ($startYear == $endYear) {
            $query->where('tahun', $startYear)
                ->whereBetween('bulan', [$startMonth, $endMonth]);
        } else {
            // Jika rentang lintas tahun
            $query->where(function ($q) use ($startYear, $startMonth, $endYear, $endMonth) {
                // Tahun awal: bulan >= startMonth
                $q->where('tahun', $startYear)
                    ->where('bulan', '>=', $startMonth)
                    // Tahun akhir: bulan <= endMonth
                    ->orWhere('tahun', $endYear)
                    ->where('bulan', '<=', $endMonth)
                    // Tahun di antara
                    ->orWhereBetween('tahun', [$startYear + 1, $endYear - 1]);
            });
        }

        $results = $query->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('kode_barang', 'asc')
            ->get();

        \Log::info('Export Results Count:', ['count' => $results->count()]);

        return $results;


    }


    public function headings(): array
    {
        if ($this->exportType === 'master') {
            return [
                'NO',
                'KODE BARANG',
                'NAMA BARANG',
                'SATUAN',
                'DEPARTEMEN',
                'SUPPLIER',
                'STOK AWAL',
                'TANGGAL SUBMIT',
                'DIBUAT PADA'
            ];
        }

        return [
            'NO',
            'KODE BARANG',
            'NAMA BARANG',
            'SATUAN',
            'STOK AWAL',
            'STOK MASUK',
            'STOK KELUAR',
            'STOK AKHIR',
            'PERIODE',
            'DEPARTEMEN',
            'SUPPLIER',
            'TANGGAL INPUT',
            'KETERANGAN',
            'STATUS'
        ];
    }

    public function map($stok): array
    {
        static $rowNumber = 1;

        if ($this->exportType === 'master') {
            $data = [
                $rowNumber++,
                $stok->kode_barang,
                $stok->nama_barang,
                $stok->satuan,
                $stok->departemen ?? '-',
                $stok->supplier ?? '-',
                number_format($stok->stok_awal, 2),
                $stok->tanggal_submit ? Carbon::parse($stok->tanggal_submit)->format('d/m/Y') : '-',
                $stok->created_at ? $stok->created_at->format('d/m/Y H:i') : '-'
            ];
        } else {
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

            $data = [
                $rowNumber++,
                $stok->kode_barang,
                $stok->nama_barang,
                $stok->satuan,
                number_format($stok->stok_awal, 2),
                number_format($stok->stok_masuk, 2),
                number_format($stok->stok_keluar, 2),
                number_format($stok->stok_akhir, 2),
                ($bulanList[$stok->bulan] ?? $stok->bulan) . ' ' . $stok->tahun,
                $stok->departemen ?? '-',
                $stok->supplier ?? '-',
                $stok->created_at ? $stok->created_at->format('d/m/Y') : '-',
                $stok->keterangan ?? '-',
                $stok->is_rollover ? 'Hasil Rollover' : 'Reguler'
            ];
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        // Style untuk data
        $dataStyle = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D3D3D3']
                ]
            ]
        ];

        // Style untuk kolom angka (rata kanan)
        $numberStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        // Apply styles
        $lastColumn = $this->exportType === 'master' ? 'I' : 'N';
        $headerRange = 'A1:' . $lastColumn . '1';

        // Header style
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);

        // Auto size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Data style untuk semua baris data
        $sheet->getStyle('A2:' . $lastColumn . ($sheet->getHighestRow()))->applyFromArray($dataStyle);

        // Number formatting untuk kolom stok
        if ($this->exportType === 'master') {
            $sheet->getStyle('G2:G' . $sheet->getHighestRow())->applyFromArray($numberStyle);
        } else {
            $numberColumns = ['D', 'E', 'F', 'G']; // Kolom D-G: Stok Awal, Masuk, Keluar, Akhir
            foreach ($numberColumns as $col) {
                $sheet->getStyle($col . '2:' . $col . $sheet->getHighestRow())->applyFromArray($numberStyle);
            }
        }

        // Set judul sheet
        $sheet->setTitle($this->exportType === 'master' ? 'Master Stok' : 'Detail Stok');

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }

    /**
     * Optional: Set column widths
     */
    public function columnWidths(): array
    {
        if ($this->exportType === 'master') {
            return [
                'A' => 8,    // NO
                'B' => 15,   // KODE BARANG
                'C' => 40,   // NAMA BARANG
                'D' => 12,   // SATUAN
                'E' => 20,   // DEPARTEMEN
                'F' => 20,   // SUPPLIER
                'G' => 12,   // STOK AWAL
                'H' => 15,   // TANGGAL SUBMIT
                'I' => 18,   // DIBUAT PADA
            ];
        }

        return [
            'A' => 8,    // NO
            'B' => 15,   // KODE BARANG
            'C' => 40,   // NAMA BARANG
            'D' => 12,   // SATUAN
            'E' => 12,   // STOK AWAL
            'F' => 12,   // STOK MASUK
            'G' => 12,   // STOK KELUAR
            'H' => 12,   // STOK AKHIR
            'I' => 15,   // PERIODE
            'J' => 20,   // DEPARTEMEN
            'K' => 20,   // SUPPLIER
            'L' => 15,   // TANGGAL INPUT
            'M' => 30,   // KETERANGAN
            'N' => 15,   // STATUS
        ];
    }
}