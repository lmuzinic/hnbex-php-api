<?php

namespace Hnbex\Common;


use Traversable;

class CurrencyExchangeRateCollection implements \IteratorAggregate
{
    /**
     * @var CurrencyExchangeRate[]
     */
    private $rates = [];

    /**
     * @param CurrencyExchangeRate $currencyExchangeRate
     */
    public function add(CurrencyExchangeRate $currencyExchangeRate)
    {
        $this->rates[$currencyExchangeRate->getCurrencyCode()] = $currencyExchangeRate;
    }

    /**
     * @param string $currencyCode
     * @return CurrencyExchangeRate|null
     */
    public function findRate(string $currencyCode)
    {
        if (array_key_exists($currencyCode, $this->rates)) {
            return $this->rates[$currencyCode];
        }

        return null;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->rates);
    }
}
