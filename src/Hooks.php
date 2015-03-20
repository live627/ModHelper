<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Hooks
{
	protected $hooks = array();
	protected $collection;

	public function execute($add)
	{
		foreach ($this->collection as list ($hook, $function, $permanent)) {
			if ($add) {
				add_integration_function($hook, $function, $permanent);
			} else {
				remove_integration_function($hook, $function, $permanent);
			}
		}
	}

	public function add($hook, $function, $permanent = true)
	{
		$this->collection->addValue([$hook, $function, $permanent]);

		return $this;
	}

	public function __construct()
	{
		$this->collection = new Collection();

		return $this;
	}

}
