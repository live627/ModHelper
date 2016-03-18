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
        $this->l = new MockLinktree();

        $this->l->add(
            'Foo',
            '/vendor/foo'
        );

        $this->l->add(
            'BarDoom',
            '/vendor/foo.bardoom'
        );

    }

    public function testLinkCount()
    {
        $this->assertCount(2, array(
            'Baz Dib',
            '/vendor/baz.dib'
        ));
    }
}
