<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Command;

use App\Entity\Currency;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Services\Api\CurrencyRates as CurrencyProvider;

class LoadData extends Command
{
    private EntityManagerInterface $em;

    private CurrencyProvider $currencyProvider;

    public function __construct(EntityManagerInterface $em, CurrencyProvider $currencyProvider)
    {
        parent::__construct();

        $this->em = $em;
        $this->currencyProvider = $currencyProvider;
    }

    protected function configure()
    {
        $this->setName('load:currency');
        $this->setDescription('Persist currencies');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Attempting to import the feed');

        $results = $this->currencyProvider->deserializeCurrency();

        foreach ($results as $row) {
            $currency = new Currency();
            $currency->setName($row['Currency']);
            $currency->setCurrencyCode($row['Code']);
            $currency->setExchangeRate($row['Mid']);

            $this->em->persist($currency);
        }

        $this->em->flush();
        $io->success('Everything went well');
    }

}