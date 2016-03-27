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
    protected $l;

    protected function setUp()
    {
        $this->l = new MockCollection;

        $this->c[1] = 'value';
        $this->c['1'] = 'value';
        $this->c['01'] = 'value';
        $this->c[TRUE] = 'value';
        $this->c[1.1] = 'value';
        $this->c[NULL] = 'value';
        $this->c[array()] = 'value';
        $this->c[$this->c] = 'value';
    }

    public function testExists()
    {
        $this->assertTrue(isset($this->c[1]));
        $this->assertTrue(isset($this->c['1']));
        $this->assertTrue(isset($this->c['01']));
        $this->assertTrue(isset($this->c[TRUE]));
        $this->assertTrue(isset($this->c[1.1]));
        $this->assertTrue(isset($this->c[NULL]));
        $this->assertTrue(isset($this->c[array()]));
        $this->assertTrue(isset($this->c[$this->c]));
    }

    public function testGet()
    {
        $this->assertSame('value', $this->c[1]);
        $this->assertSame('value', $this->c['1']);
        $this->assertSame('value', $this->c['01']);
        $this->assertSame('value', $this->c[TRUE]);
        $this->assertSame('value', $this->c[1.1]);
        $this->assertSame('value', $this->c[NULL]);
        $this->assertSame('value', $this->c[array()]);
        $this->assertSame('value', $this->c[$this->c]);
    }

    public function testGet()
    {
        unset($this->c[1]);
        unset($this->c['1']);
        unset($this->c['01']);
        unset($this->c[TRUE]);
        unset($this->c[1.1]);
        unset($this->c[NULL]);
        unset($this->c[array()]);
        unset($this->c[$this->c]);
        $this->assertCount(0, count($this->c));
    }

    public function testCollectionCount()
    {
        $this->assertCount(8, count($this->c));
    }
}
