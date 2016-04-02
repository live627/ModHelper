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
            'name' => 'Foo',
            'url' => '/vendor/foo',
            'extra_before' => 'before foo',
            'extra_after' => 'after foo'
        );
        $this->assertContains($expect, $this->l->getLinktree());

        $expect = array(
            'name' => 'BarDoom',
            'url' => '/vendor/foo.bardoom',
            'extra_before' => 'before bardoom',
            'extra_after' => 'after bardoom'
        );
        $this->assertContains($expect, $this->l->getLinktree());
    }

    public function testMissingLink()
    {
        $expect = array(
            'name' => 'Baz Dib',
            'url' => '/vendor/baz.dib',
            'extra_before' => 'before baz',
            'extra_after' => 'after baz'
        );
        $this->assertNotContains($expect, $this->l->getLinktree());
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->l->getLinktree());
    }
}
