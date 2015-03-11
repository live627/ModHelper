<?php

namespace ModHelper;

/**
 * This file deals with the verification widget, abstracting it away to keep the logic simple to follow.
 *
 * @package ModHelper
 * @since 1.0
 */
class Verify
{
	private $id;

	public function __construct($id)
	{
		$this->id = $id;
	}

	private function initialize($do_test)
	{
		global $sourcedir;
		require_once($sourcedir . '/Subs-Editor.php');
		$options = array(
			'id' => $this->id,
		);

		return create_control_verification($options, $do_test);
	}

	public function output()
	{
		global $txt;
		echo '
				<strong>', $txt['verification'], ':</strong>', template_control_verification($this->id, 'quick_reply'), '<br />';
	}
}

?>