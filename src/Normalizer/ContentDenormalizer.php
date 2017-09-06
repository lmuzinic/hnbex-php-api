<?php

namespace Hnbex\Normalizer;


use Hnbex\Common\CurrencyExchangeRateCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ContentDenormalizer
{
    public function denormalize(string $content): CurrencyExchangeRateCollection
    {
        $serializer = new Serializer(
            [
                new ContentNormalizer(),
            ],
            [
                new JsonEncoder()
            ]
        );

        $deserialize = $serializer->deserialize($content, 'Hnbex\Common\CurrencyExchangeRate[]', 'json');

        return $deserialize;
    }
}
