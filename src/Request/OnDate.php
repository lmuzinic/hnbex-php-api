<?php

namespace Hnbex\Request;


use function GuzzleHttp\Psr7\build_query;
use Hnbex\Assert\Assert;

class OnDate implements Request
{
    /**
     * @var string
     */
    private $date;

    private function __construct(string $date)
    {
        $this->date = $date;
    }

    public function getMethod(): string
    {
        return static::METHOD;
    }

    public function getUri(): string
    {
        $params = build_query([
            'date' => $this->date
        ]);

        return static::URI . '?' . $params;
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): OnDate
    {
        Assert::date($dateTime);

        return new static($dateTime->format('Y-m-d'));
    }

    public static function fromString(string $date = 'now'): OnDate
    {
        return static::fromDateTime(new \DateTimeImmutable($date));
    }

    public function getCacheKey(): string
    {
        return sha1($this->date);
    }
}
