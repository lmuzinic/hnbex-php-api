<?php
declare(strict_types=1);

namespace Hnbex\Provider;

use Hnbex\Normalizer\ContentDenormalizer;
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
     * @var ContentDenormalizer
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

        $this->denormalizer = new ContentDenormalizer();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function send(Request $request): Response
    {
        if ($this->cachePool->has($request->getCacheKey())) {
            $cachedJsonContent = $this->cachePool->get($request->getCacheKey());
            $collectionContent = $this->denormalizer->denormalize($cachedJsonContent);

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

        $jsonContent = $response->getBody()->getContents();
        $collectionContent = $this->denormalizer->denormalize($jsonContent);

        $this->cachePool->set(
            $request->getCacheKey(),
            $jsonContent
        );

        return Collection::create(
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
