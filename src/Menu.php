<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
abstract class Menu
{
	protected $options;
	protected $areas;

	public function execute()
	{
		global $sourcedir;

		foreach ($this->options as $item) {
			$options[] = $item;
		}
		foreach ($this->areas as $item) {
			$areas[] = $item;
		}

		require_once($sourcedir . '/Subs-Menu.php');
		return createMenu($areas, $options);
	}

	/**
	 * Extend this method to define all the menu structure - see Subs-Menu.php for details!
	 *
	 * @access protected
	 * @return void
	 */
	abstract protected function load();

	public function __construct()
	{
		$this->options = new Collection();
		$this->areas = new Collection();
		$this->load();

		return $this;
	}

}
