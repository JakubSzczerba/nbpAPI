<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Currency;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Api\CurrencyRates as CurrencyProvider;

class CurrencyController extends AbstractController
{
    private CurrencyProvider $currencyProvider;

    public function __construct(CurrencyProvider $currencyProvider)
    {
        $this->currencyProvider = $currencyProvider;
    }

    #[Route('/exchange/rates')]
    public function getExchangeRates()
    {
        $rates = $this->currencyProvider->integration();
    }

    #[Route('/add/currency')]
    public function addCurrency()
    {
    }

}