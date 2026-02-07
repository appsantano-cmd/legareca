<?php

namespace App\Exports;

use App\Models\StokKitchen;
use App\Models\StokStationMasterKitchen;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StokKitchenExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $namaBahan;
    protected $shift;

    public function __construct($startDate, $endDate, $namaBahan = null, $shift = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->namaBahan = $namaBahan;
        $this->shift = $shift;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = StokKitchen::query();
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }
        
        if ($this->namaBahan) {
            $query->where('nama_bahan', 'like', '%' . $this->namaBahan . '%');
        }
        
        if ($this->shift) {
            $query->where('shift', $this->shift);
        }
        
        return $query->orderBy('tanggal', 'asc')
                    ->orderBy('shift', 'asc')
                    ->orderBy('nama_bahan', 'asc')
                    ->get()
                    ->map(function($item, $key) {
                        // Ambil stok minimum dari master kitchen
                        $master = StokStationMasterKitchen::where('kode_bahan', $item->kode_bahan)->first();
                        $stokMinimum = $master ? $master->stok_minimum : 0;
                        
                        // Tentukan status stok
                        $status = $item->stok_akhir >= $stokMinimum ? 'SAFE' : 'REORDER';
                        
                        return [
                            'no' => $key + 1,
                            'tanggal' => $item->tanggal->format('d/m/Y'),
                            'shift' => 'Shift ' . $item->shift,
                            'kode_bahan' => $item->kode_bahan,
                            'nama_bahan' => $item->nama_bahan,
                            'nama_satuan' => $item->nama_satuan,
                            'stok_awal' => number_format($item->stok_awal, 2),
                            'stok_masuk' => number_format($item->stok_masuk, 2),
                            'stok_keluar' => number_format($item->stok_keluar, 2),
                            'waste' => number_format($item->waste, 2),
                            'stok_akhir' => number_format($item->stok_akhir, 2),
                            'status_stok' => $status,
                            'pic' => $item->pic,
                            'alasan_waste' => $item->alasan_waste ?? '-',
                        ];
                    });
    }

    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'SHIFT',
            'KODE BAHAN',
            'NAMA BAHAN',
            'SATUAN',
            'STOK AWAL',
            'STOK MASUK',
            'STOK KELUAR',
            'WASTE',
            'STOK AKHIR',
            'STATUS',
            'PIC',
            'ALASAN WASTE'
        ];
    }

    public function title(): string
    {
        return 'Stok Kitchen';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,    // NO
            'B' => 12,   // TANGGAL
            'C' => 10,   // SHIFT
            'D' => 15,   // KODE BAHAN
            'E' => 30,   // NAMA BAHAN
            'F' => 12,   // SATUAN
            'G' => 12,   // STOK AWAL
            'H' => 12,   // STOK MASUK
            'I' => 12,   // STOK KELUAR
            'J' => 12,   // WASTE
            'K' => 12,   // STOK AKHIR
            'L' => 10,   // STATUS
            'M' => 20,   // PIC
            'N' => 30,   // ALASAN WASTE
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '667EEA'], // Warna ungu gradient
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);

        // Set tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Style untuk data
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $dataRange = 'A2:N' . $lastRow;
            
            // Border untuk semua data
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E0E0E0'],
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
            
            $sheet->getStyle('C2:C' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            
            $sheet->getStyle('G2:K' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ]);
            
            $sheet->getStyle('L2:L' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            // Warna untuk kolom stok
            $sheet->getStyle('H2:H' . $lastRow)->applyFromArray([
                'font' => ['color' => ['rgb' => '2E7D32']], // Hijau untuk stok masuk
            ]);
            
            $sheet->getStyle('I2:I' . $lastRow)->applyFromArray([
                'font' => ['color' => ['rgb' => 'F57C00']], // Orange untuk stok keluar
            ]);
            
            $sheet->getStyle('J2:J' . $lastRow)->applyFromArray([
                'font' => ['color' => ['rgb' => 'C62828']], // Merah untuk waste
            ]);

            // Style untuk kolom status
            for ($row = 2; $row <= $lastRow; $row++) {
                $statusCell = $sheet->getCell('L' . $row)->getValue();
                
                if ($statusCell === 'SAFE') {
                    $sheet->getStyle('L' . $row)->applyFromArray([
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
                    $sheet->getStyle('L' . $row)->applyFromArray([
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

                // Alternating row colors
                if ($row % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8F9FA'],
                        ],
                    ]);
                }
            }

            // Wrap text untuk alasan waste
            $sheet->getStyle('N2:N' . $lastRow)->getAlignment()->setWrapText(true);
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
                    
                // Set header untuk setiap halaman
                $event->sheet->getHeaderFooter()
                    ->setOddHeader('&C&HStok Station Harian Kitchen');
                    
                // Set gridlines untuk print
                $event->sheet->setShowGridlines(false);
            },
        ];
    }
}