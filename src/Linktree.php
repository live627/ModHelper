<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
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

	public function add($name, $url = null, $before = null, $after = null, $first = false)
	{
		$item = array(
			'name' => $name,
		);
		if ($url !== null)
			$item['url'] = $url;
		if ($before !== null)
			$item['extra_before'] = $before;
		if ($after !== null)
			$item['extra_after'] = $after

		$this->collection->addValue($item);

		return $this;
	}

	public function __construct()
	{
		$this->collection = new Collection();

		return $this;
	}

}
