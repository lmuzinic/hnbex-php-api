<?php

namespace Hnbex\Provider;


use Cache\Adapter\Void\VoidCachePool;
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

    public function testSendReturnsContentWithoutModifications()
    {
        $this->stream->method('getContents')
            ->willReturn('unchanged string');
        $response = $this->backend->send(OnDate::fromString('today'));

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('unchanged string', $response->getContent());
        $this->assertFalse($response->isCached());
    }

    public function tearDown()
    {
        unset($this->backend);
    }
}
