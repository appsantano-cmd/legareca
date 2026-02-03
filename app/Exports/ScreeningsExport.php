<?php

namespace App\Exports;

use App\Models\Screening;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScreeningsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $search;
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct($search = null, $status = null, $startDate = null, $endDate = null)
    {
        $this->search = $search;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Screening::with('pets')->latest();

        // Apply filters sama seperti di controller index
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('owner_name', 'like', "%{$this->search}%")
                    ->orWhere('phone_number', 'like', "%{$this->search}%")
                    ->orWhereHas('pets', function ($q2) {
                        $q2->where('name', 'like', "%{$this->search}%");
                    });
            });
        }

        if ($this->status && $this->status !== 'all') {
            $query->where('status', $this->status);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Screening',
            'Status Screening',
            'Tanggal Screening',
            'Nama Owner',
            'Nomor Telepon',
            'Jumlah Pet',
            
            // Data Pet
            'Nama Pet',
            'Breed',
            'Jenis Kelamin',
            'Usia',
            'Status Vaksin',
            'Hasil Pemeriksaan Kutu',
            'Tindakan Kutu',
            'Hasil Pemeriksaan Jamur',
            'Status Birahi',
            'Tindakan Birahi',
            'Kondisi Kulit',
            'Kondisi Telinga',
            'Riwayat Kesehatan',
            'Status Pet',
            
            // Additional Info
            'Dibuat Pada',
            'Diupdate Pada'
        ];
    }

    /**
     * @param Screening $screening
     * @return array
     */
    public function map($screening): array
    {
        $rows = [];
        
        foreach ($screening->pets as $pet) {
            $rows[] = [
                $screening->id,
                $screening->status_text,
                $screening->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                $screening->owner_name,
                $screening->phone_number,
                $screening->pet_count,
                
                // Pet Data
                $pet->name,
                $pet->breed,
                $pet->sex,
                $pet->age,
                $pet->vaksin,
                $pet->kutu,
                $pet->kutu_action ? ($pet->kutu_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') : '-',
                $pet->jamur,
                $pet->birahi,
                $pet->birahi_action ? ($pet->birahi_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat') : '-',
                $pet->kulit,
                $pet->telinga,
                $pet->riwayat,
                $pet->status_text,
                
                // Timestamps
                $screening->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                $screening->updated_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];
        }
        
        return $rows;
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID Screening
            'B' => 15,  // Status Screening
            'C' => 20,  // Tanggal Screening
            'D' => 25,  // Nama Owner
            'E' => 20,  // Nomor Telepon
            'F' => 12,  // Jumlah Pet
            'G' => 20,  // Nama Pet
            'H' => 20,  // Breed
            'I' => 15,  // Jenis Kelamin
            'J' => 15,  // Usia
            'K' => 15,  // Status Vaksin
            'L' => 20,  // Hasil Kutu
            'M' => 15,  // Tindakan Kutu
            'N' => 20,  // Hasil Jamur
            'O' => 15,  // Status Birahi
            'P' => 15,  // Tindakan Birahi
            'Q' => 15,  // Kondisi Kulit
            'R' => 15,  // Kondisi Telinga
            'S' => 20,  // Riwayat Kesehatan
            'T' => 15,  // Status Pet
            'U' => 20,  // Dibuat Pada
            'V' => 20,  // Diupdate Pada
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:V1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '667eea'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Wrap text untuk kolom tertentu
        $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Nama Owner
        $sheet->getStyle('S')->getAlignment()->setWrapText(true); // Riwayat Kesehatan

        // Border untuk seluruh data
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Center align untuk kolom tertentu
        $centerColumns = ['A', 'B', 'F', 'I', 'K', 'M', 'O', 'P', 'Q', 'R', 'T'];
        foreach ($centerColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $lastRow)->getAlignment()->setHorizontal('center');
        }

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }
}