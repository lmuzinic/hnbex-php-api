<?php

namespace Hnbex\Response;


class Json implements Response
{
    /**
     * @var bool
     */
    private $cached;

    /**
     * @var string
     */
    private $content;

    private function __construct(string $content, bool $cached)
    {
        $this->content = $content;
        $this->cached = $cached;
    }

    public function isCached(): bool
    {
        return $this->cached;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public static function create($content, $cached)
    {
        return new static($content, $cached);
    }
}
