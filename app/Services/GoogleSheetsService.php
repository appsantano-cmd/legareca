<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    protected Sheets $service;
    protected string $spreadsheetId;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('LeGareca');
        $client->setScopes([
            Sheets::SPREADSHEETS,
            \Google\Service\Drive::DRIVE,
        ]);

        $client->setAuthConfig(config('services.google.credentials'));

        $this->service = new Sheets($client);
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    /**
     * 🔹 Set / overwrite header Google Sheets
     * Controller = single source of truth
     */
    public function setHeader(array $headers, string $range = 'Tukar Shift!A1'): void
    {
        $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            $range,
            new ValueRange([
                'values' => [$headers],
            ]),
            [
                'valueInputOption' => 'RAW',
            ]
        );
    }

    /**
     * 🔹 Append satu baris data
     */
    public function append(array $values, string $range = 'Tukar Shift!A2'): void
    {
        $body = new ValueRange([
            'values' => [$values],
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    /**
     * 🔹 Append banyak baris sekaligus (batch)
     * Sangat disarankan untuk export / sync ulang
     */
    public function appendMany(array $rows, string $range = 'Tukar Shift!A2'): void
    {
        if (empty($rows)) {
            return;
        }

        $body = new ValueRange([
            'values' => $rows,
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }
        /**
     * ⚠️ Escape hatch (untuk repository legacy)
     * Akses langsung Google Sheets SDK jika memang dibutuhkan
     */
    public function raw(): Sheets
    {
        return $this->service;
    }

    /**
     * Read values helper
     */
    public function getValues(string $range): array
    {
        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            $range
        );

        return $response->getValues() ?? [];
    }

    /**
     * Append raw helper (multi rows)
     */
    public function appendRaw(array $rows, string $range): void
    {
        if (empty($rows)) return;

        $body = new ValueRange([
            'values' => $rows,
        ]);

        $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            [
                'valueInputOption' => 'USER_ENTERED',
                'insertDataOption' => 'INSERT_ROWS',
            ]
        );
    }

}
