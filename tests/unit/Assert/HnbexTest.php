<?php

namespace Hnbex\Assert;


class HnbexTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionIfDateBeforeHnbStart()
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::date(new \DateTimeImmutable('1994-05-29'));
    }

    public function testThrowsExceptionIfDateAfterToday()
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::date(new \DateTimeImmutable('tomorrow'));
    }

    public function testShouldNotThrowExceptionForToday()
    {
        Assert::date(new \DateTimeImmutable('now'));

        $this->assertTrue(true);
    }

    public function testShouldNotThrowExceptionForHnbStart()
    {
        Assert::date(new \DateTimeImmutable('1994-05-30'));

        $this->assertTrue(true);
    }
}
