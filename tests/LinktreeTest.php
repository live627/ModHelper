<?php

namespace ModHelper\Tests;

class MockLinktree extends \ModHelper\Linktree
{
    protected $Links = array();

    public function setLinks(array $Links)
    {
        $this->Links = $Links;
    }

    protected function requireLink($Link)
    {
        return in_array($Link, $this->Links);
    }
}

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $linktree;

    protected function setUp()
    {
        $this->linktree = new MockLinktree;

        $this->linktree->addNamespace(
            'Foo',
            '/vendor/foo'
        );

        $this->linktree->addNamespace(
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
        $this->assertContains($expect, $this->collection);

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom'
        );
        $this->assertContains($expect, $this->collection);
    }

    public function testMissingLink()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $this->collection);
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->collection);
    }
}
