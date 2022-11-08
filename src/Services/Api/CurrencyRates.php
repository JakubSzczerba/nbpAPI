<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Api;

use GuzzleHttp\Client;
use App\Entity\Currency;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyRates
{
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function integration(): Client
    {
        $client = new Client(['base_uri' => 'http://api.nbp.pl/api/exchangerates/tables/A/']);

        return $client;
    }

    public function deserializeCurrency()
    {
        $data = $this->integration()->get('http://api.nbp.pl/api/exchangerates/tables/A/')->getBody()->getContents();

        $currencies = $this->serializer->deserialize($data, Currency::class, 'xml');

        return $currencies;
    }

}