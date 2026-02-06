<?php

namespace App\Exports;

use App\Models\Shifting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TukarShiftExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $endDate;

    /**
     * Constructor dengan parameter filter tanggal
     */
    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Mengambil data dari database dengan filter tanggal
     */
    public function collection()
    {
        $query = Shifting::query();

        // Filter berdasarkan tanggal jika ada
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        } elseif ($this->startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->startDate)->startOfDay());
        } elseif ($this->endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->endDate)->endOfDay());
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Menentukan heading untuk Excel
     */
    public function headings(): array
    {
        return [
            'NO',
            'ID',
            'NAMA KARYAWAN',
            'DIVISI/JABATAN',
            'TANGGAL SHIFT ASLI',
            'JAM SHIFT ASLI',
            'TANGGAL SHIFT TUJUAN',
            'JAM SHIFT TUJUAN',
            'ALASAN PENGAJUAN',
            'SUDAH ADA PENGGANTI?',
            'NAMA KARYAWAN PENGGANTI',
            'TANGGAL SHIFT PENGGANTI',
            'JAM SHIFT PENGGANTI',
            'STATUS',
            'DIAJUKAN PADA'
        ];
    }

    /**
     * Memetakan data dari model ke array untuk Excel
     */
    public function map($shift): array
    {
        // Format tanggal sesuai dengan tampilan di view
        $formatTanggalIndo = function ($date) {
            if (!$date) return '-';
            return Carbon::parse($date)->format('d/m/Y');
        };

        $formatJam = function ($time) {
            if (!$time) return '-';
            return Carbon::parse($time)->format('H:i');
        };

        $formatCreatedAt = function ($date) {
            if (!$date) return '-';
            return Carbon::parse($date)->format('d/m/Y H:i');
        };

        return [
            '', // NO (akan diisi otomatis dengan nomor urut)
            $shift->id, // ID
            $shift->nama_karyawan,
            $shift->divisi_jabatan,
            $formatTanggalIndo($shift->tanggal_shift_asli),
            $formatJam($shift->jam_shift_asli),
            $formatTanggalIndo($shift->tanggal_shift_tujuan),
            $formatJam($shift->jam_shift_tujuan),
            $shift->alasan,
            strtoupper($shift->sudah_pengganti),
            $shift->nama_karyawan_pengganti ?? '-',
            $formatTanggalIndo($shift->tanggal_shift_pengganti),
            $formatJam($shift->jam_shift_pengganti),
            $this->translateStatus($shift->status),
            $formatCreatedAt($shift->created_at),
        ];
    }

    /**
     * Menerjemahkan status ke bahasa Indonesia
     */
    private function translateStatus($status): string
    {
        $translations = [
            'pending' => 'MENUNGGU',
            'approved' => 'DISETUJUI',
            'rejected' => 'DITOLAK',
            'disetujui' => 'DISETUJUI',
            'ditolak' => 'DITOLAK',
        ];

        return $translations[$status] ?? strtoupper($status);
    }

    /**
     * Mengatur styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Jumlah total data + header
        $totalRows = $this->collection()->count() + 1;

        return [
            // Header styling - baris 1
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2C3E50'] // Warna primary dari CSS Anda
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ],
            ],
            // Data rows
            'A2:O' . $totalRows => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            // Alignment khusus untuk kolom
            'A' => ['alignment' => ['horizontal' => 'center']],
            'B' => ['alignment' => ['horizontal' => 'center']],
            'E' => ['alignment' => ['horizontal' => 'center']],
            'F' => ['alignment' => ['horizontal' => 'center']],
            'G' => ['alignment' => ['horizontal' => 'center']],
            'H' => ['alignment' => ['horizontal' => 'center']],
            'J' => ['alignment' => ['horizontal' => 'center']],
            'L' => ['alignment' => ['horizontal' => 'center']],
            'M' => ['alignment' => ['horizontal' => 'center']],
            'N' => ['alignment' => ['horizontal' => 'center']],
            'O' => ['alignment' => ['horizontal' => 'center']],
            // Kolom alasan - wrap text
            'I' => ['alignment' => ['wrapText' => true]],
            // Kolom nama karyawan dan divisi
            'C' => ['alignment' => ['horizontal' => 'left']],
            'D' => ['alignment' => ['horizontal' => 'left']],
        ];
    }

    /**
     * Nama worksheet
     */
    public function title(): string
    {
        return 'Data Tukar Shift';
    }

    /**
     * Event untuk freeze panes (membekukan header)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Freeze panes pada baris 2 (setelah header)
                $event->sheet->getDelegate()->freezePane('A2');
                
                // Hapus autofilter jika ada
                $event->sheet->getDelegate()->setAutoFilter('');
                
                // Tambahkan nomor urut secara otomatis
                $totalRows = $this->collection()->count();
                for ($i = 2; $i <= $totalRows + 1; $i++) {
                    $event->sheet->setCellValue("A{$i}", $i - 1);
                }
                
                // Set tinggi baris header
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35);
                
                // Set tinggi baris data
                for ($i = 2; $i <= $totalRows + 1; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(25);
                }
                
                // Set lebar kolom khusus untuk kolom alasan (lebih lebar)
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(40);
                
                // Set lebar kolom untuk kolom nama karyawan
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                
                // Set lebar kolom untuk divisi/jabatan
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                
                // Set lebar kolom untuk alasan
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(40);
                
                // Set lebar kolom untuk status
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(15);
                
                // Style untuk status
                $totalRows = $this->collection()->count();
                for ($i = 2; $i <= $totalRows + 1; $i++) {
                    $status = $event->sheet->getCell("N{$i}")->getValue();
                    if ($status == 'MENUNGGU') {
                        $event->sheet->getStyle("N{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FFF3CD']
                            ],
                            'font' => [
                                'color' => ['rgb' => '856404']
                            ]
                        ]);
                    } elseif ($status == 'DISETUJUI') {
                        $event->sheet->getStyle("N{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D4EDDA']
                            ],
                            'font' => [
                                'color' => ['rgb' => '155724']
                            ]
                        ]);
                    } elseif ($status == 'DITOLAK') {
                        $event->sheet->getStyle("N{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F8D7DA']
                            ],
                            'font' => [
                                'color' => ['rgb' => '721C24']
                            ]
                        ]);
                    }
                }
                
                // Style untuk kolom "Sudah Ada Pengganti?"
                for ($i = 2; $i <= $totalRows + 1; $i++) {
                    $pengganti = $event->sheet->getCell("J{$i}")->getValue();
                    if ($pengganti == 'YA') {
                        $event->sheet->getStyle("J{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D4EDDA']
                            ],
                            'font' => [
                                'color' => ['rgb' => '155724']
                            ]
                        ]);
                    } elseif ($pengganti == 'BELUM') {
                        $event->sheet->getStyle("J{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'E9ECEF']
                            ],
                            'font' => [
                                'color' => ['rgb' => '495057']
                            ]
                        ]);
                    }
                }
            },
        ];
    }
}