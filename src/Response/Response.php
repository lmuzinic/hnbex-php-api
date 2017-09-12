<?php
declare(strict_types=1);

namespace Hnbex\Response;

interface Response
{
    public function isCached(): bool;
    public function getContent();
}
