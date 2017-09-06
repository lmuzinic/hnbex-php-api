<?php

namespace Hnbex\Common;


class CurrencyExchangeRateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyExchangeRate
     */
    protected $currencyExchangeRate;

    public function setUp()
    {
        $this->currencyExchangeRate = CurrencyExchangeRate::fromArray([
            "currency_code" => 'EUR',
            "buying_rate" => 1,
            "median_rate" => 2,
            "selling_rate" => 3,
            "unit_value" => 4,
        ]);
    }

    public function testGetters()
    {
        $this->assertEquals('EUR', $this->currencyExchangeRate->getCurrencyCode());
        $this->assertEquals(1, $this->currencyExchangeRate->getBuyingRate());
        $this->assertEquals(2, $this->currencyExchangeRate->getMedianRate());
        $this->assertEquals(3, $this->currencyExchangeRate->getSellingRate());
        $this->assertEquals(4, $this->currencyExchangeRate->getUnitValue());
    }

    public function tearDown()
    {
        unset($this->currencyExchangeRate);
    }
}
