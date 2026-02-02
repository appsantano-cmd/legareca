<?php

namespace App\Exports;

use App\Models\StokTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $tipe;

    public function __construct($startDate = null, $endDate = null, $tipe = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tipe = $tipe;
    }

    public function collection()
    {
        $query = StokTransaction::query()
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by date range
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('tanggal', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('tanggal', '<=', $this->endDate);
        }

        // Filter by tipe
        if ($this->tipe && in_array($this->tipe, ['masuk', 'keluar'])) {
            $query->where('tipe', $this->tipe);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'TANGGAL',
            'KODE BARANG',
            'NAMA BARANG',
            'TIPE TRANSAKSI',
            'JUMLAH',
            'SATUAN',
            'DEPARTEMEN',
            'SUPPLIER',
            'KEPERLUAN',
            'NAMA PENERIMA',
            'KETERANGAN',
            'TIMESTAMP'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->tanggal->format('d/m/Y'),
            $transaction->kode_barang,
            $transaction->nama_barang,
            $transaction->tipe == 'masuk' ? 'MASUK' : 'KELUAR',
            number_format($transaction->jumlah, 2),
            $transaction->satuan,
            $transaction->departemen ?? '-',
            $transaction->supplier ?? '-',
            $transaction->keperluan ?? '-',
            $transaction->nama_penerima,
            $transaction->keterangan ?? '-',
            $transaction->created_at->format('d/m/Y H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Freeze panes pada baris kedua (header di baris 1 akan freeze)
        $sheet->freezePane('A2');
        
        // Alternative: Jika ingin freeze baris pertama saja
        // $sheet->freezePane('A2'); // Ini akan freeze baris 1
        // $sheet->freezePane('B2'); // Jika ingin freeze kolom A juga
        
        // Atau untuk freeze baris pertama dan kolom pertama:
        // $sheet->freezePane('B2');

        // Style untuk header
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Style untuk data
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))
            ->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Style untuk kolom jumlah (agar rata kanan)
        $sheet->getStyle('E2:E' . ($sheet->getHighestRow()))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Style untuk border
        $sheet->getStyle('A1:L' . ($sheet->getHighestRow()))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Wrap text untuk kolom tertentu
        $sheet->getStyle('D2:D' . ($sheet->getHighestRow()))
            ->getAlignment()
            ->setWrapText(true);
        $sheet->getStyle('K2:K' . ($sheet->getHighestRow()))
            ->getAlignment()
            ->setWrapText(true);

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // TANGGAL
            'B' => 15, // KODE BARANG
            'C' => 30, // NAMA BARANG
            'D' => 25, // TIPE TRANSAKSI
            'E' => 12, // JUMLAH
            'F' => 10, // SATUAN
            'G' => 15, // DEPARTEMEN
            'H' => 25, // SUPPLIER
            'I' => 30, // KEPERLUAN
            'J' => 25, // NAMA PENERIMA
            'K' => 30, // KETERANGAN
            'L' => 20, // TIMESTAMP
        ];
    }

    public function title(): string
    {
        return 'Transaksi Stok';
    }
}