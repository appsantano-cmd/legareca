<?php

namespace App\Exports;

use App\Models\StokBar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class StokBarExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = StokBar::query();
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }
        
        return $query->orderBy('tanggal', 'asc')
            ->orderBy('shift', 'asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'No' => $index + 1,
                    'Tanggal' => $item->tanggal->format('d/m/Y'),
                    'Shift' => 'Shift ' . $item->shift,
                    'Kode Bahan' => $item->kode_bahan,
                    'Nama Bahan' => $item->nama_bahan,
                    'Satuan' => $item->nama_satuan,
                    'Stok Awal' => number_format($item->stok_awal, 2),
                    'Stok Masuk' => number_format($item->stok_masuk, 2),
                    'Stok Keluar' => number_format($item->stok_keluar, 2),
                    'Waste' => number_format($item->waste, 2),
                    'Stok Akhir' => number_format($item->stok_akhir, 2),
                    'Status' => $item->status_stok,
                    'PIC' => $item->pic,
                    'Alasan Waste' => $item->alasan_waste ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Shift',
            'Kode Bahan',
            'Nama Bahan',
            'Satuan',
            'Stok Awal',
            'Stok Masuk',
            'Stok Keluar',
            'Waste',
            'Stok Akhir',
            'Status',
            'PIC',
            'Alasan Waste',
        ];
    }

    public function title(): string
    {
        return 'Stok Bar';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,  // No
            'B' => 12, // Tanggal
            'C' => 10, // Shift
            'D' => 15, // Kode Bahan
            'E' => 25, // Nama Bahan
            'F' => 12, // Satuan
            'G' => 12, // Stok Awal
            'H' => 12, // Stok Masuk
            'I' => 12, // Stok Keluar
            'J' => 12, // Waste
            'K' => 12, // Stok Akhir
            'L' => 12, // Status
            'M' => 15, // PIC
            'N' => 25, // Alasan Waste
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Jangan styling apa-apa di sini karena akan dihandle di registerEvents
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Set judul sheet
                $sheet->setTitle('Stok Bar');
                
                // Header kolom langsung di baris 1 (tanpa judul dan periode)
                $headerRange = 'A1:N1';
                
                // Styling untuk header kolom
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '8a2387'],
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
                
                // Set row height untuk header
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Styling untuk data
                $lastRow = $sheet->getHighestRow();
                if ($lastRow > 1) {
                    $dataRange = 'A2:N' . $lastRow;
                    
                    // Alternating row colors
                    for ($row = 2; $row <= $lastRow; $row++) {
                        $fillColor = $row % 2 == 0 ? 'f8f9fa' : 'ffffff';
                        $sheet->getStyle("A{$row}:N{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => $fillColor],
                            ],
                        ]);
                    }
                    
                    // Border untuk semua sel data
                    $sheet->getStyle($dataRange)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'dddddd'],
                            ],
                        ],
                    ]);
                    
                    // Alignment untuk kolom numerik
                    $numericColumns = ['G', 'H', 'I', 'J', 'K']; // G=Stok Awal, H=Masuk, I=Keluar, J=Waste, K=Akhir
                    foreach ($numericColumns as $column) {
                        $sheet->getStyle("{$column}2:{$column}{$lastRow}")->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            ],
                        ]);
                    }
                    
                    // Alignment untuk kolom status
                    $sheet->getStyle("L2:L{$lastRow}")->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                    
                    // Alignment untuk kolom No dan Shift (center)
                    $sheet->getStyle("A2:A{$lastRow}")->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                    
                    $sheet->getStyle("C2:C{$lastRow}")->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                    
                    // Set text alignment untuk kolom lainnya (left)
                    $textColumns = ['B', 'D', 'E', 'F', 'M', 'N'];
                    foreach ($textColumns as $column) {
                        $sheet->getStyle("{$column}2:{$column}{$lastRow}")->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_LEFT,
                            ],
                        ]);
                    }
                }
                
                // Freeze header row (baris 1)
                $sheet->freezePane('A2');
                
                // Auto size columns
                foreach (range('A', 'N') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Set optimal column widths
                $sheet->getColumnDimension('E')->setWidth(30); // Nama Bahan lebih lebar
                $sheet->getColumnDimension('N')->setWidth(30); // Alasan Waste lebih lebar
            },
        ];
    }
}