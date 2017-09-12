<?php

namespace Hnbex\Normalizer;


use Hnbex\Assert\Assert;
use Hnbex\Normalizer\ResponseDenormalizer;
use Psr\Http\Message\StreamInterface;

class ContentDenormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseDenormalizer
     */
    private $contentDenormalizer;

    public function setUp()
    {
        $this->contentDenormalizer = new ResponseDenormalizer();
    }

    public function testContentDenormalizerReturnsArrayOfCurrencyExchangeRates()
    {
        $response = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('[{"buying_rate": "5.187953", "selling_rate": "5.219175", "currency_code": "AUD", "unit_value": 1, "median_rate": "5.203564"}, {"buying_rate": "5.455269", "selling_rate": "5.488099", "currency_code": "CAD", "unit_value": 1, "median_rate": "5.471684"}, {"buying_rate": "0.277469", "selling_rate": "0.279139", "currency_code": "CZK", "unit_value": 1, "median_rate": "0.278304"}, {"buying_rate": "1.013266", "selling_rate": "1.019364", "currency_code": "DKK", "unit_value": 1, "median_rate": "1.016315"}, {"buying_rate": "2.401400", "selling_rate": "2.415852", "currency_code": "HUF", "unit_value": 100, "median_rate": "2.408626"}, {"buying_rate": "5.522219", "selling_rate": "5.555453", "currency_code": "JPY", "unit_value": 100, "median_rate": "5.538836"}, {"buying_rate": "0.861997", "selling_rate": "0.867185", "currency_code": "NOK", "unit_value": 1, "median_rate": "0.864591"}, {"buying_rate": "0.821108", "selling_rate": "0.826050", "currency_code": "SEK", "unit_value": 1, "median_rate": "0.823579"}, {"buying_rate": "7.271418", "selling_rate": "7.315178", "currency_code": "CHF", "unit_value": 1, "median_rate": "7.293298"}, {"buying_rate": "10.633516", "selling_rate": "10.697510", "currency_code": "GBP", "unit_value": 1, "median_rate": "10.665513"}, {"buying_rate": "6.759091", "selling_rate": "6.799767", "currency_code": "USD", "unit_value": 1, "median_rate": "6.779429"}, {"buying_rate": "7.559367", "selling_rate": "7.604859", "currency_code": "EUR", "unit_value": 1, "median_rate": "7.582113"}, {"buying_rate": "1.804834", "selling_rate": "1.815696", "currency_code": "PLN", "unit_value": 1, "median_rate": "1.810265"}]');

        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $denormalisedContent = $this->contentDenormalizer->denormalize($response);

        $this->assertInstanceOf(\Hnbex\Common\CurrencyExchangeRateCollection::class, $denormalisedContent);
        $this->assertContainsOnlyInstancesOf('Hnbex\Common\CurrencyExchangeRate', $denormalisedContent);
        $this->assertNotEmpty($denormalisedContent);
    }

    /**
     * @expectedException \Exception
     */
    public function testContentDenormalizeThrowsExceptionWhenBadJson()
    {
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('[{"bad_json');

        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $this->contentDenormalizer->denormalize($response);
    }


    /**
     * @expectedException \Exception
     */
    public function testContentDenormalizeThrowsExceptionWhenGarbageInJson()
    {
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('[{"some":"data"}]');

        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $this->contentDenormalizer->denormalize($response);
    }

    public function tearDown()
    {
        unset($this->contentDenormalizer);
    }
}
