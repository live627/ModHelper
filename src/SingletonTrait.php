<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
trait SingletonTrait
{
    /**
     * Create Singleton instance.
     *
     * @return Singleton instance
     */
    final public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Prevent creating Singleton instance by "new" keyword.
     */
    final private function __construct()
    {
    }
    
    protected function init() 
    {
    }

    /**
     * Prevent cloning Singleton instance.
     */
    final private function __clone()
    {
    }

    /**
     * Prevent unserializing Singleton instance.
     */
    final private function __wakeup()
    {
    }
}
