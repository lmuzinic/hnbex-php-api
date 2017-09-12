<?php

namespace Hnbex\integration;


use Cache\Adapter\Filesystem\FilesystemCachePool;
use Hnbex\Normalizer\ResponseDenormalizer;
use Hnbex\Provider\Backend;
use Hnbex\Request\OnDate;
use Http\Adapter\Guzzle6\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class BackendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $adapter;

    /**
     * @var FilesystemCachePool
     */
    private $cache;

    public function setUp()
    {
        $this->adapter = new Client();

        $filesystemAdapter = new Local('var');
        $filesystem        = new Filesystem($filesystemAdapter);
        $filesystem->deleteDir('cache');

        $this->cache = new FilesystemCachePool($filesystem);
    }

    public function testSendActualRequestForDateInPast()
    {
        $backend = new Backend($this->adapter, $this->cache);
        $response = $backend->send(OnDate::fromString('2015-07-01'));

        $this->assertNotEmpty($response);
    }

    public function testSendActualRequestForToday()
    {
        $backend = new Backend($this->adapter, $this->cache);
        $response = $backend->send(OnDate::fromString('today'));

        $this->assertNotEmpty($response);
    }

    public function testSendActualRequestForWeirdDate()
    {
        $backend = new Backend($this->adapter, $this->cache);
        $response = $backend->send(OnDate::fromString('Jan 31st 1996'));

        $this->assertNotEmpty($response);
    }

    public function tearDown()
    {
        unset($this->adapter);
    }
}
