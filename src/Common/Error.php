<?php

namespace Hnbex\Common;


use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Error
{
    private $message;

    private function __construct(string $message)
    {
        $this->setMessage($message);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public static function fromArray(array $value)
    {
        $errorMessage = self::configure($value);

        return new static(
            $errorMessage['error']
        );
    }

    private static function configure(array $value)
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired([
            'error'
        ]);

        $resolver->setNormalizer('error', function (Options $options, $value) {
            return (string)$value;
        });

        return $resolver->resolve($value);
    }
}
