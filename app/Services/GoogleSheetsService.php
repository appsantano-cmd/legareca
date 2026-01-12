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
        $credentials = config('services.google.credentials');

        if (! file_exists($credentials)) {
            throw new \RuntimeException(
                "Google credentials file not found: {$credentials}"
            );
        }

        $client = new Client();
        $client->setApplicationName('Laravel Tukar Shift');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials);
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    public function append(array $values): void
    {
        $range = 'Tukar Shift!A:M';

        $body = new ValueRange([
            'values' => [$values],
        ]);

        $params = [
            'valueInputOption' => 'RAW',
        ];

        $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}
