<?php

namespace App\Repositories;

use App\Services\GoogleSheetsService;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\ValueRange;

class PengajuanIzinSheetRepository
{
    protected string $spreadsheetId;
    protected $service;
    protected string $sheetName = 'Pengajuan Izin';

    public function __construct()
    {
        $this->spreadsheetId = config('services.google.spreadsheet_id')
            ?? '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';

        $this->service = GoogleSheetsService::client();
    }

    /**
     * Pastikan sheet ada (create kalau belum)
     */
    public function ensureSheetExists(): void
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
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

            $this->service->spreadsheets
                ->batchUpdate($this->spreadsheetId, $batchRequest);
        }

        // 🔥 SELALU pastikan header ada
        $this->ensureHeaderExists();
    }

    protected function ensureHeaderExists(): void
    {
        $range = "{$this->sheetName}!A1:M1";

        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            $range
        );

        $values = $response->getValues();

        // Jika baris 1 kosong → tulis header
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

        $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            "{$this->sheetName}!A1:N1",
            new ValueRange(['values' => $headers]),
            ['valueInputOption' => 'RAW']
        );
    }
    /**
 * Sync data pengajuan izin dari database ke Google Sheet
 */
    /**
 * Sync data pengajuan izin dari database ke Google Sheet
 */
public function syncFromDatabase($izin): void
{
    $existingIds = $this->getExistingIds();

    $rows = [];

    foreach ($izin as $item) {
        if (in_array($item->id, $existingIds)) {
            continue; // ⛔ sudah ada → skip
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
            $item->created_at
                ? $item->created_at->format('Y-m-d H:i:s')
                : '',
        ];
    }

    if (empty($rows)) {
        return; // tidak ada data baru
    }

    $this->service->spreadsheets_values->append(
        $this->spreadsheetId,
        "{$this->sheetName}!A:N",
        new \Google\Service\Sheets\ValueRange([
            'values' => $rows,
        ]),
        [
            'valueInputOption' => 'USER_ENTERED',
            'insertDataOption' => 'INSERT_ROWS',
        ]
    );
}

/**
 * Ambil semua pengajuan_id yang sudah ada di Sheet
 */
protected function getExistingIds(): array
{
    $range = "{$this->sheetName}!A2:A";

    $response = $this->service->spreadsheets_values->get(
        $this->spreadsheetId,
        $range
    );

    $values = $response->getValues() ?? [];

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
        $item->created_at
            ? $item->created_at->format('Y-m-d H:i:s')
            : '',
    ]];

    $this->service->spreadsheets_values->append(
        $this->spreadsheetId,
        "{$this->sheetName}!A:N",
        new ValueRange([
            'values' => $values
        ]),
        [
            'valueInputOption' => 'USER_ENTERED',
            'insertDataOption' => 'INSERT_ROWS',
        ]
    );
}
public function fetchApprovalStatuses(): array
{
    $response = $this->service->spreadsheets_values->get(
        $this->spreadsheetId,
        "{$this->sheetName}!A2:N"
    );

    $rows = $response->getValues() ?? [];
    $result = [];

    foreach ($rows as $row) {
        $id = $row[0] ?? null;
        $status = $row[12] ?? null; // kolom M (0-based)

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
