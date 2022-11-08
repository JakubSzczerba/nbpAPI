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
use GuzzleHttp\Client;

class CurrencyController extends AbstractController
{
    #[Route('/exchange/rates')]
    public function getExchangeRates()
    {
    }

}