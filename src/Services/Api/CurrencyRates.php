<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Api;

use GuzzleHttp\Client;

class CurrencyRates
{
    public function integration(): Client
    {
        $client = new Client(['base_uri' => 'http://api.nbp.pl/api/exchangerates/tables/A/']);

        return $client;
    }

}