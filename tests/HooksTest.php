<?php

namespace ModHelper\Tests;

class MockHooks extends \ModHelper\Hooks
{
    private $h;

    public function getHooks()
    {
        if (!$this->h)
            $this->h = iterator_to_array($this->collection);

        return $this->h;
    }
}

class HooksTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        $this->l = new MockHooks;

        $this->l->add(
            'Foo',
            '/vendor/foo'
        );

        $this->l->add(
            'BarDoom',
            '/vendor/foo.bardoom'
        );

    }

    public function testExistingHook()
    {
        $expect = array(
            'Foo',
            '/vendor/foo'
        );
        $this->assertContains($expect, $this->l->getHooks());

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom'
        );
        $this->assertContains($expect, $this->l->getHooks());
    }

    public function testMissingHook()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $this->l->getHooks());
    }

    public function testHookCount()
    {
        $this->assertCount(2, $this->l->getHooks());
    }
}
