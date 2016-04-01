<?php

namespace ModHelper\Tests;

class MockCollection extends \ModHelper\Collection implements \Countable
{
    public function count()
    {
        return count($this->items);
    }
}

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $c;

    protected function setUp()
    {
        $this->c = new MockCollection;

        $this->c[1] = 'value';
        $this->c[42] = 'value';
        $this->c['01'] = 'value';
        $this->c['macaroni and flees'] = 'value';
        $this->c[1.1] = 'value';
        $this->c['alphabet soup'] = 'value';
    }

    public function testExists()
    {
        $this->assertFalse(isset($this->c[11]));
        $this->assertTrue(isset($this->c[1]));
        $this->assertTrue(isset($this->c[42]));
        $this->assertTrue(isset($this->c['01']));
        $this->assertTrue(isset($this->c['macaroni and flees']));
        $this->assertTrue(isset($this->c[1.1]));
        $this->assertTrue(isset($this->c['alphabet soup']));
    }

    public function testGet()
    {
        $this->assertNull($this->c[11]);
        $this->assertSame('value', $this->c[1]);
        $this->assertSame('value', $this->c[42]);
        $this->assertSame('value', $this->c['01']);
        $this->assertSame('value', $this->c['macaroni and flees']);
        $this->assertSame('value', $this->c[1.1]);
        $this->assertSame('value', $this->c['alphabet soup']);
    }

    public function testUnset()
    {
        unset($this->c[1]);
        unset($this->c[42]);
        unset($this->c['01']);
        unset($this->c['macaroni and flees']);
        unset($this->c[1.1]);
        unset($this->c['alphabet soup']);
        $this->assertCount(0, $this->c);
    }

    public function testCount()
    {
        $this->assertCount(6, $this->c);
    }
}
