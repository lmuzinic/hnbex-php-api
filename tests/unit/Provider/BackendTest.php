<?php

namespace Hnbex\Provider;


use Cache\Adapter\Void\VoidCachePool;
use Hnbex\Common\CurrencyExchangeRateCollection;
use Hnbex\Normalizer\ContentDenormalizer;
use Hnbex\Request\OnDate;
use Hnbex\Response\Response;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class BackendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Backend
     */
    private $backend;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $stream;

    public function setUp()
    {
        $client = $this->createMock(HttpClient::class);
        $response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);

        $client->method('sendRequest')->willReturn($response);
        $response->method('getBody')->willReturn($this->stream);

        $cachePool = new VoidCachePool();
        $this->backend = new Backend($client, $cachePool);
    }

    public function testSendReturnsCurrencyExchangeRateCollection()
    {
        $this->stream->method('getContents')
            ->willReturn('[{"median_rate": "5.288542", "unit_value": 1, "currency_code": "AUD", "buying_rate": "5.272676", "selling_rate": "5.304408"}, {"median_rate": "5.326556", "unit_value": 1, "currency_code": "CAD", "buying_rate": "5.310576", "selling_rate": "5.342536"}, {"median_rate": "0.277085", "unit_value": 1, "currency_code": "CZK", "buying_rate": "0.276254", "selling_rate": "0.277916"}, {"median_rate": "1.006380", "unit_value": 1, "currency_code": "DKK", "buying_rate": "1.003361", "selling_rate": "1.009399"}, {"median_rate": "2.406387", "unit_value": 100, "currency_code": "HUF", "buying_rate": "2.399168", "selling_rate": "2.413606"}, {"median_rate": "6.109170", "unit_value": 100, "currency_code": "JPY", "buying_rate": "6.090842", "selling_rate": "6.127498"}, {"median_rate": "0.840324", "unit_value": 1, "currency_code": "NOK", "buying_rate": "0.837803", "selling_rate": "0.842845"}, {"median_rate": "0.792128", "unit_value": 1, "currency_code": "SEK", "buying_rate": "0.789752", "selling_rate": "0.794504"}, {"median_rate": "7.007157", "unit_value": 1, "currency_code": "CHF", "buying_rate": "6.986136", "selling_rate": "7.028178"}, {"median_rate": "8.780319", "unit_value": 1, "currency_code": "GBP", "buying_rate": "8.753978", "selling_rate": "8.806660"}, {"median_rate": "7.000602", "unit_value": 1, "currency_code": "USD", "buying_rate": "6.979600", "selling_rate": "7.021604"}, {"median_rate": "7.484344", "unit_value": 1, "currency_code": "EUR", "buying_rate": "7.461891", "selling_rate": "7.506797"}, {"median_rate": "1.728406", "unit_value": 1, "currency_code": "PLN", "buying_rate": "1.723221", "selling_rate": "1.733591"}]');
        $response = $this->backend->send(OnDate::fromString('today'));

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(CurrencyExchangeRateCollection::class, $response->getContent());
        $this->assertFalse($response->isCached());
    }

    public function tearDown()
    {
        unset($this->backend);
    }
}
