<?php

namespace App\Exports;

use App\Models\PengajuanIzin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajuanIzinExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize, WithEvents
{
    protected $status;
    protected $search;
    protected $start_date;
    protected $end_date;

    public function __construct($status = null, $search = null, $start_date = null, $end_date = null)
    {
        $this->status = $status;
        $this->search = $search;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = PengajuanIzin::query();
        
        // Filter status
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('jenis_izin', 'like', "%{$this->search}%")
                  ->orWhere('divisi', 'like', "%{$this->search}%");
            });
        }
        
        // Filter tanggal mulai
        if ($this->start_date) {
            $query->whereDate('tanggal_mulai', '>=', $this->start_date);
        }
        
        // Filter tanggal selesai
        if ($this->end_date) {
            $query->whereDate('tanggal_selesai', '<=', $this->end_date);
        }
        
        $query->orderBy('created_at', 'desc');
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'User Email',
            'Divisi',
            'Jenis Izin',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jumlah Hari',
            'Keterangan Tambahan',
            'Nomor Telepon',
            'Alamat',
            'Dokumen Pendukung',
            'Konfirmasi',
            'Status',
            'Catatan Admin',
            'Disetujui Oleh',
            'Tanggal Persetujuan',
            'Tanggal Input'
        ];
    }

    /**
     * @param PengajuanIzin $izin
     * @return array
     */
    public function map($izin): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $izin->nama,
            $izin->user_email ?? '-',
            $izin->divisi,
            $izin->jenis_izin,
            \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y'),
            \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y'),
            $izin->jumlah_hari,
            $izin->keterangan_tambahan ?? '-',
            $izin->nomor_telepon,
            $izin->alamat,
            $izin->documen_pendukung ? 'Ada' : 'Tidak Ada',
            $izin->konfirmasi ? 'Ya' : 'Tidak',
            $izin->status,
            $izin->catatan_admin ?? '-',
            $izin->disetujui_oleh ?? '-',
            $izin->tanggal_persetujuan ? \Carbon\Carbon::parse($izin->tanggal_persetujuan)->format('d/m/Y H:i:s') : '-',
            \Carbon\Carbon::parse($izin->created_at)->format('d/m/Y H:i:s')
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Pengajuan Izin';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris pertama)
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'] // Indigo
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Tinggi baris untuk header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Style untuk semua sel
        $sheet->getStyle('A2:R' . ($sheet->getHighestRow()))
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

        // Style untuk kolom angka
        $sheet->getStyle('H2:H' . $sheet->getHighestRow()) // Kolom Jumlah Hari
            ->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ]);

        // Style untuk tanggal
        $sheet->getStyle('F2:G' . $sheet->getHighestRow()) // Kolom tanggal
            ->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ]);

        // Style untuk status dengan warna berdasarkan nilai
        $lastRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $lastRow; $row++) {
            $status = $sheet->getCell('N' . $row)->getValue(); // Kolom N = Status
            $color = '';
            
            switch ($status) {
                case 'Pending':
                    $color = 'FFF3CD'; // Kuning muda
                    break;
                case 'Disetujui':
                    $color = 'D1E7DD'; // Hijau muda
                    break;
                case 'Ditolak':
                    $color = 'F8D7DA'; // Merah muda
                    break;
            }
            
            if ($color) {
                $sheet->getStyle('N' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => substr($color, -6)],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            }
        }

        return [];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Freeze header row (baris pertama)
                $event->sheet->freezePane('A2');
                
                $sheet = $event->sheet->getDelegate();
                
                // Set lebar kolom
                $sheet->getColumnDimension('A')->setWidth(6);   // No
                $sheet->getColumnDimension('B')->setWidth(25);  // Nama
                $sheet->getColumnDimension('C')->setWidth(30);  // Email
                $sheet->getColumnDimension('D')->setWidth(20);  // Divisi
                $sheet->getColumnDimension('E')->setWidth(20);  // Jenis Izin
                $sheet->getColumnDimension('F')->setWidth(15);  // Tgl Mulai
                $sheet->getColumnDimension('G')->setWidth(15);  // Tgl Selesai
                $sheet->getColumnDimension('H')->setWidth(12);  // Jumlah Hari
                $sheet->getColumnDimension('I')->setWidth(30);  // Keterangan
                $sheet->getColumnDimension('J')->setWidth(20);  // No Telp
                $sheet->getColumnDimension('K')->setWidth(30);  // Alamat
                $sheet->getColumnDimension('L')->setWidth(20);  // Dokumen
                $sheet->getColumnDimension('M')->setWidth(12);  // Konfirmasi
                $sheet->getColumnDimension('N')->setWidth(15);  // Status
                $sheet->getColumnDimension('O')->setWidth(30);  // Catatan Admin
                $sheet->getColumnDimension('P')->setWidth(25);  // Disetujui Oleh
                $sheet->getColumnDimension('Q')->setWidth(20);  // Tgl Persetujuan
                $sheet->getColumnDimension('R')->setWidth(20);  // Tanggal Input
            },
        ];
    }
}