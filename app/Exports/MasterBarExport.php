<?php

namespace App\Exports;

use App\Models\StokStationMasterBar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MasterBarExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = StokStationMasterBar::query();
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }
        
        return $query->orderBy('tanggal', 'desc')
                    ->orderBy('nama_bahan')
                    ->get()
                    ->map(function($item, $key) {
                        // Tentukan status stok
                        $status = $item->stok_awal >= $item->stok_minimum ? 'SAFE' : 'REORDER';
                        
                        return [
                            'no' => $key + 1,
                            'tanggal' => $item->tanggal->format('d/m/Y'),
                            'kode_bahan' => $item->kode_bahan,
                            'nama_bahan' => $item->nama_bahan,
                            'nama_satuan' => $item->nama_satuan,
                            'stok_awal' => number_format($item->stok_awal, 2),
                            'stok_minimum' => number_format($item->stok_minimum, 2),
                            'status_stok' => $status,
                        ];
                    });
    }

    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'KODE BAHAN',
            'NAMA BAHAN',
            'SATUAN',
            'STOK AWAL',
            'STOK MINIMUM',
            'STATUS STOK'
        ];
    }

    public function title(): string
    {
        return 'Master Bar';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,    // NO
            'B' => 15,   // TANGGAL
            'C' => 20,   // KODE BAHAN
            'D' => 35,   // NAMA BAHAN
            'E' => 15,   // SATUAN
            'F' => 15,   // STOK AWAL
            'G' => 15,   // STOK MINIMUM
            'H' => 15,   // STATUS STOK
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '9B59B6'], // Warna ungu untuk Bar
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Set tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Style untuk data
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $dataRange = 'A2:H' . $lastRow;
            
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alignment khusus untuk kolom tertentu
            $sheet->getStyle('A2:A' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            
            $sheet->getStyle('F2:G' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ]);

            // Style untuk kolom status
            $sheet->getStyle('H2:H' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            // Alternating row colors
            for ($row = 2; $row <= $lastRow; $row++) {
                $statusCell = $sheet->getCell('H' . $row)->getValue();
                
                if ($row % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8F9FA'],
                        ],
                    ]);
                }
                
                // Warna untuk status SAFE dan REORDER
                if ($statusCell === 'SAFE') {
                    $sheet->getStyle('H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'E8F5E9'],
                        ],
                        'font' => [
                            'color' => ['rgb' => '2E7D32'],
                            'bold' => true,
                        ],
                    ]);
                } elseif ($statusCell === 'REORDER') {
                    $sheet->getStyle('H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FFEBEE'],
                        ],
                        'font' => [
                            'color' => ['rgb' => 'C62828'],
                            'bold' => true,
                        ],
                    ]);
                }
            }

            // Auto size columns
            foreach (range('A', 'H') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(false);
            }
        }

        // Freeze panes pada baris 1 (header)
        $sheet->freezePane('A2');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set print settings
                $event->sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                
                // Set margins
                $event->sheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.5)
                    ->setLeft(0.5)
                    ->setBottom(0.5);
            },
        ];
    }
}