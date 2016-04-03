<?php

// Add a function for integration hook.
function add_integration_function($hook, $function, $permanent = true)
{
    global $modSettings;

    // Make current function list usable.
    $functions = empty($modSettings[$hook]) ? array() : explode(',', $modSettings[$hook]);

    // Do nothing, if it's already there.
    if (in_array($function, $functions))
        return;

    $functions[] = $function;
    $modSettings[$hook] = implode(',', $functions);
}

// Remove an integration hook function.
function remove_integration_function($hook, $function)
{
    global $modSettings;

    // Turn the function list into something usable.
    $functions = empty($modSettings[$hook]) ? array() : explode(',', $modSettings[$hook]);

    // You can only remove it if it's available.
    if (!in_array($function, $functions))
        return;

    $functions = array_diff($functions, array($function));
    $modSettings[$hook] = implode(',', $functions);
}

namespace ModHelper\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    protected $l;

    protected function setUp()
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $this->l = $container->get('hooks');
        $this->l->execute(true);
    }

    public function testExistingHook()
    {
        global $modSettings;

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
