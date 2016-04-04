<?php

namespace ModHelper\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        include_once __DIR__ . '/func.php';
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $this->l = $container->get('hooks');
        $this->l->execute(true);
    }

    public function testExistingHook()
    {
        global $modSettings;

        var_dump($modSettings);
        $expect = array(
            'Foo'=>
            '/vendor/foo'
        );
        $this->assertContains($expect, $modSettings);

        $expect = array(
            'BarDoom'=>
            '/vendor/foo.bardoom',
        );
        $this->assertContains($expect, $modSettings);
    }

    public function testMissingHook()
    {
        global $modSettings;

        $expect = array(
            'Baz Dib'=>
            '/vendor/baz.dib'
        );
        $this->assertNotContains($expect, $modSettings);
    }

    public function testHookCount()
    {
        global $modSettings;

        $this->assertCount(2, $modSettings);
    }
}
