<?php

namespace Hnbex\Normalizer;


use Hnbex\Common\CurrencyExchangeRateCollection;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ResponseDenormalizer
{
    public function denormalize(ResponseInterface $response)
    {
        $serializer = new Serializer(
            [
                new ErrorNormalizer(),
                new ContentNormalizer(),
            ],
            [
                new JsonEncoder()
            ]
        );

        if ($response->getStatusCode() === 200) {
            return $serializer->deserialize($response->getBody()->getContents(), 'Hnbex\Common\CurrencyExchangeRate[]', 'json');
        }

        return $serializer->deserialize($response->getBody()->getContents(), 'Hnbex\Common\Error', 'json');
    }
}
