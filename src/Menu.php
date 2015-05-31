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
	private $id;
	private $title;

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
		return createMenu(array(
			$this->id => array(
				'title' => $this->title,
				'areas' => $areas
			)), $options);
	}

	/**
	 * Adds an area to the menu structure - see Subs-Menu.php for details!
	 *
	 * @access protected
	 * @return void
	 */

	public function addArea($id, $area)
	{
		$this->areas->addValue([$id => $areas]);
	}
	/**
	 * Adds an option to the menu
	 *
	 * @access public
	 * @return void
	 */
	public function addOption($id, $val)
	{
		$this->options->addValue([$id => $val]);
	}

	public function __construct($id, $title)
	{
		$this->id = $id;
		$this->title = $title;
		$this->options = new Collection();
		$this->areas = new Collection();
		$this->load();

		return $this;
	}

}
