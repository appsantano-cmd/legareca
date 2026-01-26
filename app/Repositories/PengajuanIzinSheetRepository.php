<?php

namespace App\Repositories;

use App\Services\GoogleSheetsService;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\ValueRange;

class PengajuanIzinSheetRepository
{
    protected string $spreadsheetId;
    protected GoogleSheetsService $service;
    protected string $sheetName = 'Pengajuan Izin';

    public function __construct()
    {
        $this->spreadsheetId = config('services.google.spreadsheet_id')
            ?? '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';

        $this->service = new GoogleSheetsService();
    }

    /**
     * Pastikan sheet ada (create kalau belum)
     */
    public function ensureSheetExists(): void
    {
        $spreadsheet = $this->service->raw()->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        $exists = collect($sheets)->contains(
            fn ($sheet) =>
                $sheet->getProperties()->getTitle() === $this->sheetName
        );

        if (! $exists) {
            $request = new Request([
                'addSheet' => [
                    'properties' => [
                        'title' => $this->sheetName,
                    ],
                ],
            ]);

            $batchRequest = new BatchUpdateSpreadsheetRequest([
                'requests' => [$request],
            ]);

            $this->service->raw()
                ->spreadsheets
                ->batchUpdate($this->spreadsheetId, $batchRequest);
        }

        // 🔥 SELALU pastikan header ada
        $this->ensureHeaderExists();
    }

    protected function ensureHeaderExists(): void
    {
        $range = "{$this->sheetName}!A1:N1";
        $values = $this->service->getValues($range);

        if (empty($values)) {
            $this->addHeader();
        }
    }

    /**
     * Header kolom
     */
    protected function addHeader(): void
    {
        $headers = [[
            'Pengajuan ID',
            'Nama',
            'Divisi',
            'Jenis Izin',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jumlah Hari',
            'Keterangan',
            'Nomor Telepon',
            'Alamat',
            'Dokumen Pendukung',
            'Konfirmasi',
            'Status',
            'Created At',
        ]];

        $this->service->raw()->spreadsheets_values->update(
            $this->spreadsheetId,
            "{$this->sheetName}!A1:N1",
            new ValueRange(['values' => $headers]),
            ['valueInputOption' => 'RAW']
        );
    }

    /**
     * Sync data pengajuan izin dari database ke Google Sheet
     */
    public function syncFromDatabase($izin): void
    {
        $existingIds = $this->getExistingIds();
        $rows = [];

        foreach ($izin as $item) {
            if (in_array($item->id, $existingIds)) {
                continue;
            }

            $rows[] = [
                (int) $item->id,
                (string) $item->nama,
                (string) $item->divisi,
                (string) $item->jenis_izin,
                (string) $item->tanggal_mulai,
                (string) $item->tanggal_selesai,
                (string) $item->jumlah_hari,
                (string) $item->keterangan_tambahan,
                (string) $item->nomor_telepon,
                (string) $item->alamat,
                (string) $item->documen_pendukung,
                (string) $item->konfirmasi,
                (string) $item->status,
                optional($item->created_at)->format('Y-m-d H:i:s'),
            ];
        }

        $this->service->appendRaw(
            $rows,
            "{$this->sheetName}!A:N"
        );
    }

    /**
     * Ambil semua pengajuan_id yang sudah ada di Sheet
     */
    protected function getExistingIds(): array
    {
        $range = "{$this->sheetName}!A2:A";
        $values = $this->service->getValues($range);

        return collect($values)
            ->flatten()
            ->map(fn ($v) => (int) $v)
            ->toArray();
    }

    public function appendSingle($item): void
    {
        $values = [[
            (int) $item->id,
            (string) $item->nama,
            (string) $item->divisi,
            (string) $item->jenis_izin,
            (string) $item->tanggal_mulai,
            (string) $item->tanggal_selesai,
            (string) $item->jumlah_hari,
            (string) $item->keterangan_tambahan,
            (string) $item->nomor_telepon,
            (string) $item->alamat,
            (string) $item->documen_pendukung,
            (string) $item->konfirmasi,
            (string) $item->status,
            optional($item->created_at)->format('Y-m-d H:i:s'),
        ]];

        $this->service->appendRaw(
            $values,
            "{$this->sheetName}!A:N"
        );
    }

    public function fetchApprovalStatuses(): array
    {
        $rows = $this->service->getValues("{$this->sheetName}!A2:N");
        $result = [];

        foreach ($rows as $row) {
            $id = $row[0] ?? null;
            $status = $row[12] ?? null;

            if ($id && $status) {
                $result[] = [
                    'id' => (int) $id,
                    'status' => trim($status),
                ];
            }
        }

        return $result;
    }
}
