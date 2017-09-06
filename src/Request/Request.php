<?php
declare(strict_types=1);

namespace Hnbex\Request;

interface Request
{
    const METHOD = 'GET';
    const URI = 'http://hnbex.eu/api/v1/rates/daily/';

    public function getMethod(): string;
    public function getUri(): string;
    public function getCacheKey(): string;
}
