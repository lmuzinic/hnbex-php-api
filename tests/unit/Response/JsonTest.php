<?php

namespace Hnbex\Response;


class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCachedReturnTrueWhenCached()
    {
        $json = Json::create('{}', true);

        $this->assertTrue($json->isCached());
    }

    public function testIsCachedReturnFalseWhenNotCached()
    {
        $json = Json::create('{}', false);

        $this->assertFalse($json->isCached());
    }

    public function testReturnContent()
    {
        $json = Json::create('{}', true);

        $this->assertEquals('{}', $json->getContent());
    }
}
