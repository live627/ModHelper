<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.1
 */
class Linktree
{
	protected $collection;

	public function execute()
	{
		global $context;

		foreach ($this->collection as $item) {
			$context['linktree'][] = $item;
		}
	}

	public function add($name, $url = null, $before = null, $after = null)
	{
		$item = array(
			'name' => $name,
		);
		if ($url !== null)
			$item['url'] = $url;
		if ($before !== null)
			$item['extra_before'] = $before;
		if ($after !== null)
			$item['extra_after'] = $after;

		$this->collection->append($item);

		return $this;
	}

	public function __construct()
	{
		$this->collection = new \ArrayObject([], \ArrayObject::STD_PROP_LIST);

		return $this;
	}

}
