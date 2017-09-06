<?php

namespace Hnbex\Common;


class CurrencyExchangeRateCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyExchangeRateCollection
     */
    protected $currencyExchangeRateCollection;

    public function setUp()
    {
        $this->currencyExchangeRateCollection = new CurrencyExchangeRateCollection();
    }

    public function testAddingCurrencyExchangeRates()
    {
        $eur = CurrencyExchangeRate::fromArray([
            "currency_code" => 'EUR',
            "buying_rate" => 1,
            "median_rate" => 1,
            "selling_rate" => 1,
            "unit_value" => 1,
        ]);

        $this->currencyExchangeRateCollection->add($eur);

        $this->assertContainsOnlyInstancesOf('Hnbex\Common\CurrencyExchangeRate', $this->currencyExchangeRateCollection);
    }

    public function testAddAndFindRate()
    {
        $eur = CurrencyExchangeRate::fromArray([
            "currency_code" => 'EUR',
            "buying_rate" => 1,
            "median_rate" => 1,
            "selling_rate" => 1,
            "unit_value" => 1,
        ]);

        $this->currencyExchangeRateCollection->add($eur);

        $foundEur = $this->currencyExchangeRateCollection->findRate('EUR');
        $this->assertEquals($eur, $foundEur);
    }

    public function testAddAndFinRateReturnsNullIfNotFound()
    {
        $eur = CurrencyExchangeRate::fromArray([
            "currency_code" => 'EUR',
            "buying_rate" => 1,
            "median_rate" => 1,
            "selling_rate" => 1,
            "unit_value" => 1,
        ]);

        $this->currencyExchangeRateCollection->add($eur);

        $notFoundUsd = $this->currencyExchangeRateCollection->findRate('USD');
        $this->assertNull($notFoundUsd);
    }

    public function tearDown()
    {
        unset($this->currencyExchangeRateCollection);
    }

}
