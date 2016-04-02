<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Hooks
{
	protected $hooks = [];
	protected $collection;

	public function commit()
	{
		foreach ($this->collection as list ($hook, $function)) {
			add_integration_function($hook, $function);
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
		$this->collection->append([$hook, $function]);

		return $this;
	}

	public function __construct()
	{
		$this->collection = new ArrayObject([], ArrayObject::STD_PROP_LIST)();

		return $this;
	}

}
