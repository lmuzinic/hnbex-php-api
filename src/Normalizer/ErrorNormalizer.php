<?php

namespace Hnbex\Normalizer;


use Hnbex\Common\Error;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ErrorNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return Error::fromArray($data);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            'json' === $format &&
            'Hnbex\Common\Error' === $type &&
            isset($data['error']);
    }
}
