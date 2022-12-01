<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Services\Api;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use GuzzleHttp\Client;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyRates
{
    private CurrencyRepository $currencyRepository;

    private EntityManagerInterface $em;

    public function __construct(CurrencyRepository $currencyRepository, EntityManagerInterface $em)
    {
        $this->currencyRepository = $currencyRepository;
        $this->em = $em;
    }

    public function integration(): Client
    {
        $client = new Client(['base_uri' => 'http://api.nbp.pl/api/exchangerates/tables/A/']);

        return $client;
    }

    public function deserializeCurrency()
    {
        $data = $this->integration()->get('http://api.nbp.pl/api/exchangerates/tables/A/')->getBody()->getContents();

        $result = json_decode($data, true);

        return $result;
    }

    public function updateData(int $id): Currency
    {
        $data = $this->deserializeCurrency();
        $currency = $this->currencyRepository->find($id);
        if($currency) {
            foreach ($data as $row) {
                foreach ($row['rates'] as $rate) {
                    if ($rate['currency'] === $currency->getName()) {
                        $currency->setExchangeRate($rate['mid']);
                    }
                }
            }
        } else {
            foreach ($data as $row) {
                foreach ($row['rates'] as $rate) {
                    $currency = new Currency();
                    $currency->setName($rate['currency']);
                    $currency->setCurrencyCode($rate['code']);
                    $currency->setExchangeRate($rate['mid']);

                    $this->em->persist($currency);
                }
            }
        }
        $this->em->flush();

        return $currency;
    }

}