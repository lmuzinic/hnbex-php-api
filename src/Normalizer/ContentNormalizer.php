<?php

namespace Hnbex\Normalizer;


use Hnbex\Common\CurrencyExchangeRate;
use Hnbex\Common\CurrencyExchangeRateCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ContentNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $currencyExchangeRates = new CurrencyExchangeRateCollection();
        foreach ($data as $exchangeRate) {
            $currencyExchangeRates->add(CurrencyExchangeRate::fromArray($exchangeRate));
        }

        return $currencyExchangeRates;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            'json' === $format &&
            'Hnbex\Common\CurrencyExchangeRate[]' === $type &&
            !empty($data);
    }
}
