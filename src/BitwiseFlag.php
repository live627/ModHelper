<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */

abstract class BitwiseFlag
{
	private $flags;

	/*
	 * Note: these functions are protected to prevent outside code
	 * from falsely setting BITS.
	 */

	/**
	 * Returns the stored bits.
	 *
	 * @access protected
	 * @return int
	 */
	protected function __construct()
	{
		return $this->flags;
	}

	protected function isFlagSet($flag)
	{
		return (($this->flags & $flag) == $flag);
	}

	protected function setFlag($flag, $value)
	{
		if ($value) {
			$this->flags |= $flag;
		} else {
			$this->flags &= ~$flag;
		}
	}
}
