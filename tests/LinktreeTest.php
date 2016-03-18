<?php

namespace ModHelper\Tests;

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        $this->l = new \ModHelper\Linktree();

        $this->l->add(
            'Foo',
            '/vendor/foo'
        );

        $this->l->add(
            'BarDoom',
            '/vendor/foo.bardoom'
        );

    }
}
