<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsService
{
    public static function client(): Sheets
    {
        $client = new Client();
        $client->setApplicationName('LeGareca');
        $client->setScopes([
            Sheets::SPREADSHEETS,
            \Google\Service\Drive::DRIVE,
        ]);

        // 🔥 INI KUNCI UTAMA
        $client->setAuthConfig(storage_path('app/credentials.json'));

        return new Sheets($client);
    }
}
