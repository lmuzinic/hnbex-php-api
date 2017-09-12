<?php

namespace Hnbex\Response;


use Hnbex\Common\CurrencyExchangeRateCollection;

class Collection implements Response
{
    /**
     * @var bool
     */
    private $cached;

    /**
     * @var CurrencyExchangeRateCollection
     */
    private $content;

    private function __construct(CurrencyExchangeRateCollection $content, bool $cached)
    {
        $this->content = $content;
        $this->cached = $cached;
    }

    public function isCached(): bool
    {
        return $this->cached;
    }

    public function getContent(): CurrencyExchangeRateCollection
    {
        return $this->content;
    }

    public static function create($content, $cached)
    {
        return new static($content, $cached);
    }
}
