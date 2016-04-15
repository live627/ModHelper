<?php

namespace ModHelper\Tests;

use Pimple\Container;
use G\Yaml2Pimple\ContainerBuilder;
use G\Yaml2Pimple\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class LinktreeTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    public function getLinktree()
    {
        global $context;

        return $context['linktree'];
    }

    protected function setUp()
    {
        global $context;

        $context['linktree'] = [];

        $container = new Container();
        $loader = new YamlFileLoader(new ContainerBuilder($container), new FileLocator(__DIR__));
        $loader->load('services.yml');
        $this->l = $container['linktree'];
        // $this->l = $container->get('linktree');

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
        $this->assertContains($expect, $this->getLinktree());

        $expect = array(
            'name' => 'BarDoom',
            'url' => '/vendor/foo.bardoom',
            'extra_before' => 'before bardoom',
            'extra_after' => 'after bardoom'
        );
        $this->assertContains($expect, $this->getLinktree());
    }

    public function testMissingLink()
    {
        $expect = array(
            'name' => 'Baz Dib',
            'url' => '/vendor/baz.dib',
            'extra_before' => 'before baz',
            'extra_after' => 'after baz'
        );
        $this->assertNotContains($expect, $this->getLinktree());
    }

    public function testLinkCount()
    {
        $this->assertCount(2, $this->getLinktree());
    }
}
