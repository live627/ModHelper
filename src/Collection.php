<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Collection implements IteratorAggregate
{
	private $items = array();

	public function addValue($item)
	{
		$this->items[] = $item;
		return $this;
	}

	public function getIterator()
	{
		foreach ($this->items as $item) {
			yield $item;
		}
	}
}
