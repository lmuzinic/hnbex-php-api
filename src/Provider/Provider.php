<?php
declare(strict_types=1);

namespace Hnbex\Provider;

use Hnbex\Request\Request;

interface Provider
{
    public function send(Request $request);
}
