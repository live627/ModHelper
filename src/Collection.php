<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Collection implements \IteratorAggregate, \ArrayAccess
{
	private $items = array();

	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->items[] = $value;
		} else {
			$this->items[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this->items[$offset]);
	}

	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->items[$offset]) ? $this->items[$offset] : null;
	}

	public function addValue($item)
	{
		$this->items[] = $item;
		return $this;
	}

	public function getIterator()
	{
		foreach ($this->items as $id => $item) {
			yield $id => $item;
		}
	}
}
