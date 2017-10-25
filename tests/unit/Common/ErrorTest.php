<?php

namespace Hnbex\Common;


class ErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Error
     */
    protected $error;

    public function setUp()
    {
        $this->error = Error::fromArray([
            'error' => 'This is an error'
        ]);
    }

    public function testGetMessage()
    {
        $this->assertEquals('This is an error', $this->error->getMessage());
    }

    public function testCreateMessageThrowsExceptionWhenNoError()
    {
        $this->expectException('Symfony\Component\OptionsResolver\Exception\MissingOptionsException');

        Error::fromArray([]);
    }

    public function tearDown()
    {
        unset($this->error);
    }
}
