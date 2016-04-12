<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 * @version 1.2
 */

abstract class A
{
    protected static $instance;
    final public static function getInstance()
    {
        return isset(static::$instance)
            ? static::$instance
            : static::$instance = new static;
    }
    final private function __wakeup() {}
    final private function __clone() {}
}
