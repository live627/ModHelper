<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.0
 * @version 2.0
 */
abstract class Collection implements Interfaces\Collection
{
    /**
     * The array that holds all the items collected by the object.
     *
     * @var array
     * @access private
     */
    private $items = array();

    public function count() {
        return $this->size();
    }

    public function size() {
        return count($this->items);
    }

    public function isEmpty() {
        return $this->size() == 0;
    }

    public function clear() {
        $this->items = [];
    }

    public function toArray() {
        return $this->items;
    }

    /**
     * Whether the value is in this set
     *
     * @access public
     * @param mixed $value Value to check
     * @return boolean
     */
    public function contains($item) {
        return in_array($item, $this->items);
    }

    /**
     * Returns all keys as Set
     *
     * @return Set the map's keys
     */
    public function keys() {
        return new Set(array_keys($this->items));
    }

    /**
     * Returns all values as ArrayList
     *
     * @return ArrayList the map's values
     */
    public function values() {
        return new Set(array_values($this->items));
    }

    /**
     * Returns whether the key exist.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key) {
        return isset($this->items[$key]);
    }
}
