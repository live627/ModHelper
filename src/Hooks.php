<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.0
 */
class Hooks
{
    protected $collection;

    public function commit($add)
    {
        foreach ($this->collection as list ($hook, $function)) {
            if ($add) {
                add_integration_function($hook, $function);
            } else {
                remove_integration_function($hook, $function);
            }
        }
    }

    public function execute($add)
    {
        foreach ($this->collection as list ($hook, $function)) {
            if ($add) {
                add_integration_function($hook, $function, false);
            } else {
                remove_integration_function($hook, $function, false);
            }
        }
    }

    public function add($hook, $function)
    {
        $this->collection->add([$hook, $function]);

        return $this;
    }

    public function __construct(Set $collection, array $hooks)
    {
        $this->collection = new $collection;

        foreach ($hooks as list ($hook, $function)) {
            $this->add($hook, $function);
        }

        return $this;
    }

}
