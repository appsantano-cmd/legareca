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
     * Append 1 row ke Google Sheets
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
}
