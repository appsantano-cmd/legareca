<?php

namespace App\Exports;

use App\Models\DailyCleaningReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataCleaningExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = DailyCleaningReport::query();

        // Apply date filters if provided
        if ($this->startDate) {
            $query->whereDate('tanggal', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Staff',
            'Tanggal',
            'Departemen',
            'Status',
            'Foto Path',
            'File Size',
            'File Type',
            'Dibuat Pada',
            'Diupdate Pada'
        ];
    }

    public function map($report): array
    {
        return [
            $report->id,
            $report->nama,
            $report->tanggal instanceof \Carbon\Carbon ? $report->tanggal->format('Y-m-d') : $report->tanggal,
            $report->departemen,
            $report->status,
            $report->foto_path,
            $this->formatBytes($report->file_size),
            $report->file_type,
            $report->created_at->format('Y-m-d H:i:s'),
            $report->updated_at->format('Y-m-d H:i:s')
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => ['font' => ['bold' => true]],
        ];
    }
}