<?php

namespace ModHelper\Tests;

use Pimple\Container;
use G\Yaml2Pimple\ContainerBuilder;
use G\Yaml2Pimple\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        include_once __DIR__ . '/func.php';
        $container = new Container();
        $loader = new YamlFileLoader(new ContainerBuilder($container), new FileLocator(__DIR__));
        $loader->load('services.yml');
        $this->l = $container['hooks'];
        // $this->l = $container->get('hooks');
        $this->l->execute(true);
    }

    public function testExistingHooks()
    {
        global $modSettings;

        $expect = array(
            'Foo' => '/vendor/foo'
        );
        $this->assertArraySubset($expect, $modSettings);

        $expect = array(
            'BarDoom' => '/vendor/foo.bardoom'
        );
        $this->assertArraySubset($expect, $modSettings);
    }

    public function testMissingHook()
    {
        global $modSettings;

        $this->assertArrayNotHasKey('Baz Dib', $modSettings);
        $this->assertNotContains('/vendor/baz.dib', $modSettings);
        $this->assertCount(2, $modSettings);
    }

    public function testHookCount()
    {
        global $modSettings;

        $this->assertCount(2, $modSettings);
    }
    
    public function testRemoveHooks()
    {
        global $modSettings;

        $this->l->execute(false);
        $this->assertArrayHasKey('Foo', $modSettings);
        $this->assertArrayHasKey('BarDoom', $modSettings);
        $this->assertNotContains('/vendor/foo', $modSettings);
        $this->assertNotContains('/vendor/foo.bardoom', $modSettings);
        $this->assertCount(2, $modSettings);
    }

    public function testCommitHooks()
    {
        global $modSettings;

        $this->l->commit(false);
        $this->assertArrayHasKey('Foo', $modSettings);
        $this->assertArrayHasKey('BarDoom', $modSettings);
        $this->assertNotContains('/vendor/foo', $modSettings);
        $this->assertNotContains('/vendor/foo.bardoom', $modSettings);
        $this->assertCount(2, $modSettings);

        $this->l->commit(true);
        $this->assertArrayHasKey('Foo', $modSettings);
        $this->assertArrayHasKey('BarDoom', $modSettings);
        $this->assertContains('/vendor/foo', $modSettings);
        $this->assertContains('/vendor/foo.bardoom', $modSettings);
        $this->assertCount(2, $modSettings);
    }
}
