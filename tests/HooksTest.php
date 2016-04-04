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

        $expect = array(
            'Baz Dib' => '/vendor/baz.dib'
        );
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
