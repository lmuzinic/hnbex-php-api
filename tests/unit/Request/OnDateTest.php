<?php

namespace Hnbex\Request;


class OnDateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OnDate
     */
    protected $date;

    public function setUp()
    {
        $this->date = OnDate::fromString('2017-01-01');
    }

    public function testGettingMethod()
    {
        $method = $this->date->getMethod();

        $this->assertEquals('GET', $method);
    }

    public function testGettingURI()
    {
        $uri = $this->date->getUri();

        $this->assertEquals('http://hnbex.eu/api/v1/rates/daily/?date=2017-01-01', $uri);
    }

    public function testCreatingFromDateTime()
    {
        $dateTime = new \DateTimeImmutable('January 1st 2017');
        $this->date = OnDate::fromDateTime($dateTime);

        $uri = $this->date->getUri();
        $this->assertEquals('http://hnbex.eu/api/v1/rates/daily/?date=2017-01-01', $uri);
    }

    public function tearDown()
    {
        unset($this->date);
    }

}
