<?php

namespace App\Services;

use Google_Client;
// use Google_Service_Sheets;
use Google\Service\Sheets;

class GoogleService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets Import');
        $this->client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $this->client->setAuthConfig(storage_path('app/google/erocpgrafana-c71d96865952.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
        $this->spreadsheetId = config('services.google.sheet_id');
        // $service = new Google_Service_Sheets($this->client);
    }

    public function getData($range)
    {
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }
}
