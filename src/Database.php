<?php

namespace ModHelper;

/**
 * This file deals with some database internals.
 *
 * @package ModHelper
 * @since 1.0
 */
class Database
{
	/**
	 * Handler to SMF's database functions.
	 *
	 * @example ModHelper\Database::query('', 'SELECT * FROM smf_themes', array());
	 * @param string $name The name (or key) of the $smcFunc you are calling.
	 * @param string $arguments This is an array of all arguments passed to the method.
	 * @return mixed The $smcFunc return value or false if not found.
	 * @since 3.0
	 * @version 3.0
	 */
	public static function __callStatic($name, $arguments)
	{
		global $smcFunc;
		if (isset($smcFunc[$name = 'db_' . $name])) {
			return call_user_func_array($smcFunc[$name], $arguments);
		}

		return false;
	}
}

?>