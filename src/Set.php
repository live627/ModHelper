<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 2.0
 */
class Set extends Collection implements Interfaces\Set
{
    /**
     * Creates a new Set
     *
     * @param array|Collection $items
     */
    public function __construct($items = []) {
        $this->addAll($items);
    }

    /**
     * Appends a value to the object
     *
     * This method is chainable.
     *
     * @access public
     * @param mixed The value to set
     * @return Set $this
     */
    public function add($item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Adds all items to the set
     *
     * @param array|Collection $items
     * @return Set $this
     */
    public function addAll($items) {
        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * Removes an item from the set
     *
     * This method is chainable.
     *
     * @access public
     * @param mixed $item
     * @return Set $this
     */
    public function remove($item) {
        $index = array_search($item, $this->items, true);
        if ($index !== null) {
            unset($this->items[$index]);
        }

        return $this;
    }

    /**
     * Removes all items from the set
     *
     * @param array|Collection $items
     */
    public function removeAll($items) {
        foreach ($items as $item) {
            $this->remove($item);
        }
    }

    /**
     * @return Set
     */
    public function map(callable $callback) {
        return new Set(array_map($callback, $this->items));
    }

    public function filter(callable $callback) {
        return new Set(array_values(array_filter($this->items, $callback)));
    }

    /**
     * Retrieve an external iterator.
     *
     * @access public
     * @abstracting IteratorAggregate
     */
    public function getIterator()
    {
        foreach ($this->items as $id => $item) {
            yield $id => $item;
        }
    }
}
