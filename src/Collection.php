<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Collection implements \IteratorAggregate, \ArrayAccess
{
	/**
	 * The array that holds all the items collected by the object.
	 *
	 * @var array
	 * @access protected
	 */
	protected $items = array();

	/**
	 * Assigns a value to the specified offset
	 *
	 * @param string The offset to assign the value to
	 * @param mixed  The value to set
	 * @access public
	 * @abstracting ArrayAccess
	 * @since 1.1
	 * @version 1.1
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
	 * @since 1.1
	 * @version 1.1
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
	 * @since 1.1
	 * @version 1.1
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
	 * @since 1.1
	 * @version 1.1
	 */
	public function offsetGet($offset)
	{
		return isset($this->items[$offset]) ? $this->items[$offset] : null;
	}

	/**
	 * Appends a value to the object
	 *
	 * This method is chainable.
	 *
	 * @param mixed  The value to set
	 * @access public
	 * @since 1.0
	 * @version 1.0
	 */
	public function addValue($item)
	{
		$this->items[] = $item;
		return $this;
	}

	/**
	 * Retrieve an external iterator.
	 *
	 * @access public
	 * @abstracting IteratorAggregate
	 * @since 1.0
	 * @version 1.1
	 */
	public function getIterator()
	{
		foreach ($this->items as $id => $item) {
			yield $id => $item;
		}
	}
}
