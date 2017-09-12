<?php
declare(strict_types=1);

namespace Hnbex\Provider;

use Hnbex\Response\Error;
use Hnbex\Normalizer\ResponseDenormalizer;
use Hnbex\Response\Collection;
use Http\Client\HttpClient;
use Hnbex\Response\Response;
use Hnbex\Response\Json;
use Hnbex\Request\Request;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Serializer\Serializer;

class Backend implements Provider
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var CacheInterface
     */
    private $cachePool;

    /**
     * @var ResponseDenormalizer
     */
    private $denormalizer;

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

        $this->denormalizer = new ResponseDenormalizer();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function send(Request $request): Response
    {
        if ($this->cachePool->has($request->getCacheKey())) {
            $collectionContent = $this->cachePool->get($request->getCacheKey());

            return Collection::create(
                $collectionContent,
                true
            );
        }

        $httpRequest = $this->getMessageFactory()->createRequest(
            $request->getMethod(),
            $request->getUri()
        );

        $response = $this->httpClient->sendRequest($httpRequest);
        $collectionContent = $this->denormalizer->denormalize($response);

        if ($response->getStatusCode() === 200) {
            $this->cachePool->set(
                $request->getCacheKey(),
                $collectionContent
            );

            return Collection::create(
                $collectionContent,
                false
            );
        }

        return Error::create(
            $collectionContent,
            false
        );
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
