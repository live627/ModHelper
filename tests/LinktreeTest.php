<?php

namespace ModHelper\Tests;

class MockLinktree extends \ModHelper\Linktree
{
    public function getLinktree()
    {
        global $context;

        return $context['linktree'];
    }
}

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        global $context;

        $context['linktree'] = [];
        $this->l = new MockLinktree;

        $this->l->add(
            'Foo',
            '/vendor/foo',
            'before foo',
            'after foo'
        );

        $this->l->add(
            'BarDoom',
            '/vendor/foo.bardoom',
            'before bardoom',
            'after bardoom'
        );
        $this->l->execute();
    }

    public function testExistingLink()
    {
        $expect = array(
            'Foo',
            '/vendor/foo',
            'before foo',
            'after foo'
        );
        $this->assertContains($expect, $this->l->getLinktree());

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom',
            'before bardoom',
            'after bardoom'
        );
        $this->assertContains($expect, $this->l->getLinktree());
    }

    public function testMissingLink()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib',
            'before baz',
            'after baz'
        );
        $this->assertNotContains($expect, $this->l->getLinktree());
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->l->getLinktree());
    }
}
