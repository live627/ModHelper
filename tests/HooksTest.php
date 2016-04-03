<?php

namespace ModHelper\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    protected $l;
    protected $c;

    protected function setUp()
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $this->l = $container->get('hooks');
        $this->c = $container->get('collection');
    }

    public function testExistingHook()
    {
        $expect = array(
            'Foo',
            '/vendor/foo'
        );
        $this->assertContains($expect, $this->c->getArrayCopy());

        $expect = array(
            'BarDoom',
            '/vendor/foo.bardoom'
        );
        $this->assertContains($expect, $this->c->getArrayCopy());
    }

    public function testMissingHook()
    {
        $expect = array(
            'Baz Dib',
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $this->c->getArrayCopy());
    }

    public function testHookCount()
    {
        $this->assertCount(2, $this->cc);
    }
}
