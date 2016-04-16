<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 2.0
 */
class Map extends Collection implements Interfaces\Map
{
    /**
     * Creates a new Map
     *
     * @param array|Map $data
     */
    public function __construct($items) {
        $this->setAll($items);
        var_dump($items, $this->items);
    }

    /**
     * Sets an item with the given key on that map
     *
     * @param string key
     * @param mixed $item
     * @return Map $this
     */
    public function set($key, $item) {
        $this->items[$key] = $item;

        return $this;
    }

    /**
     * Returns the item for the given key or nothing if the key does not exist.
     *
     * @param string $key
     */
    public function get($key) {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
    }


    /**
     * Sets many items on that map
     *
     * @param array|Map $items
     * @return Map $this
     */
    public function setAll($items) {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }

        return $this;
    }

    /**
     * Removes and returns an item from the map by the given key. Returns null if the key
     * does not exist.
     *
     * @param string $key
     * @return mixed the item at the given key
     */
    public function remove($key) {
        if (isset($this->items[$key])) {
            $item = $this->items[$key];
            unset($this->items[$key]);

            return $item;
        }
    }

    /**
     * @return Map
     */
    public function map(callable $callback) {
        return new Map(array_map($callback, $this->items));
    }

    /**
     * @return Map
     */
    public function filter(callable $callback) {
        return new Map(array_filter($this->items, $callback));
    }

    /**
     * Assigns a value to the specified offset
     *
     * @param string The offset to assign the value to
     * @param mixed  The value to set
     * @access public
     * @abstracting ArrayAccess
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Whether or not an offset exists
     *
     * @param string An offset to check for
     * @access public
     * @return boolean
     * @abstracting ArrayAccess
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Unsets an offset
     *
     * @param string The offset to unset
     * @access public
     * @abstracting ArrayAccess
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Returns the value at specified offset
     *
     * @param string The offset to retrieve
     * @access public
     * @return mixed
     * @abstracting ArrayAccess
     */
    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
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
