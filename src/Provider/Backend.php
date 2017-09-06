<?php
declare(strict_types=1);

namespace Hnbex\Provider;

use Http\Client\HttpClient;
use Hnbex\Response\Response;
use Hnbex\Response\Json;
use Hnbex\Request\Request;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\SimpleCache\CacheInterface;

class Backend implements Provider
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    private $cachePool;

    /**
     * @var MessageFactory;
     */
    private $messageFactory;

    /**
     * @param $httpClient
     */
    public function __construct(HttpClient $httpClient, CacheInterface $cachePool)
    {
        $this->httpClient = $httpClient;
        $this->cachePool = $cachePool;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function send(Request $request)
    {
        if ($this->cachePool->has($request->getCacheKey())) {
            return Json::create(
                $this->cachePool->get($request->getCacheKey()),
                true
            );
        }

        $httpRequest = $this->getMessageFactory()->createRequest(
            $request->getMethod(),
            $request->getUri()
        );

        $response = $this->httpClient->sendRequest($httpRequest);
        $jsonContent = $response->getBody()->getContents();

        $this->cachePool->set(
            $request->getCacheKey(),
            $jsonContent
        );

        return Json::create($jsonContent, false);
    }

    /**
     * @return MessageFactory
     */
    public function getMessageFactory()
    {
        if ($this->messageFactory === null) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }

        return $this->messageFactory;
    }

    /**
     * @codeCoverageIgnore
     * @param MessageFactory $messageFactory
     * @return Backend
     */
    public function setMessageFactory(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;

        return $this;
    }
}
