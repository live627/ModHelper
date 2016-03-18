<?php

namespace ModHelper\Tests;

class MockLinktree extends \ModHelper\Linktree
{
    public function getLinks()
    {
        return $this->collection;
    }
}

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        $this->l = new MockLinktree;

        $this->l->add(
            'Foo',
            '/vendor/foo'
        );

        $this->l->add(
            'BarDoom',
            '/vendor/foo.bardoom'
        );

    }

    public function testExistingLink()
    {
        $expect = array(
            'Foo',
            '/vendor/foo'
        );
        $this->assertContains($expect, $this->l->getLinks());

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom'
        );
        $this->assertContains($expect, $this->l->getLinks());
    }

    public function testMissingLink()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $this->l->getLinks());
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->l->getLinks());
    }
}
