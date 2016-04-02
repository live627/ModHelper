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
		$options = [];

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
	 * @access public
	 * @return void
	 */
	public function addArea($id, $area)
	{
		$this->areas->$id = $area;
	}

	/**
	 * Adds an option to the menu
	 *
	 * @access public
	 * @return void
	 */
	public function addOption($id, $option)
	{
		$this->options->$id = $option;
	}

	public function __construct($id, $title)
	{
		$this->id = $id;
		$this->title = $title;
		$this->options = new ArrayObject([], ArrayObject::STD_PROP_LIST);
		$this->areas = new ArrayObject([], ArrayObject::STD_PROP_LIST);
	}

}
