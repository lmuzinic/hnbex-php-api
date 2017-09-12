<?php

namespace Hnbex\Response;


use Hnbex\Common\Error as ErrorMessage;

class Error implements Response
{
    /**
     * @var bool
     */
    private $cached;

    /**
     * @var ErrorMessage
     */
    private $content;

    private function __construct(ErrorMessage $content, bool $cached)
    {
        $this->content = $content;
        $this->cached = $cached;
    }

    public function isCached(): bool
    {
        return $this->cached;
    }

    public function getContent(): ErrorMessage
    {
        return $this->content;
    }

    public static function create($content, $cached)
    {
        return new static($content, $cached);
    }
}
