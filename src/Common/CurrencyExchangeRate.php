<?php

namespace Hnbex\Common;


use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyExchangeRate
{
    private $buyingRate;
    private $sellingRate;
    private $medianRate;
    private $currencyCode;
    private $unitValue;

    private function __construct(
        float $buyingRate,
        float $sellingRate,
        float $medianRate,
        string $currencyCode,
        int $unitValue
    )
    {
        $this->setBuyingRate($buyingRate);
        $this->setSellingRate($sellingRate);
        $this->setMedianRate($medianRate);
        $this->setCurrencyCode($currencyCode);
        $this->setUnitValue($unitValue);
    }

    /**
     * @return float
     */
    public function getBuyingRate()
    {
        return $this->buyingRate;
    }

    /**
     * @param float $buyingRate
     */
    public function setBuyingRate(float $buyingRate)
    {
        $this->buyingRate = $buyingRate;
    }

    /**
     * @return float
     */
    public function getSellingRate()
    {
        return $this->sellingRate;
    }

    /**
     * @param float $sellingRate
     */
    public function setSellingRate(float $sellingRate)
    {
        $this->sellingRate = $sellingRate;
    }

    /**
     * @return float
     */
    public function getMedianRate()
    {
        return $this->medianRate;
    }

    /**
     * @param float $medianRate
     */
    public function setMedianRate(float $medianRate)
    {
        $this->medianRate = $medianRate;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return int
     */
    public function getUnitValue()
    {
        return $this->unitValue;
    }

    /**
     * @param int $unitValue
     */
    public function setUnitValue(int $unitValue)
    {
        $this->unitValue = $unitValue;
    }

    public static function fromArray(array $value)
    {
        $rateItem = self::configure($value);

        return new static(
            $rateItem['buying_rate'],
            $rateItem['selling_rate'],
            $rateItem['median_rate'],
            $rateItem['currency_code'],
            $rateItem['unit_value']
        );
    }

    private static function configure(array $value)
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired([
            'buying_rate',
            'selling_rate',
            'currency_code',
            'unit_value',
            'median_rate'
        ]);

        $resolver->setNormalizer('buying_rate', function (Options $options, $value) {
            return (float)$value;
        });

        $resolver->setNormalizer('selling_rate', function (Options $options, $value) {
            return (float)$value;
        });

        $resolver->setNormalizer('median_rate', function (Options $options, $value) {
            return (float)$value;
        });

        $resolver->setNormalizer('currency_code', function (Options $options, $value) {
            return (string)$value;
        });

        $resolver->setNormalizer('unit_value', function (Options $options, $value) {
            return (int)$value;
        });

        return $resolver->resolve($value);
    }
}
