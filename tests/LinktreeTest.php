<?php

namespace ModHelper\Tests;

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        $this->l = new \ModHelper\Linktree;

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
        $this->assertContains($expect, $this->l->collection);

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom'
        );
        $this->assertContains($expect, $this->l->collection);
    }

    public function testMissingLink()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $this->l->collection);
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->l->collection);
    }
}
