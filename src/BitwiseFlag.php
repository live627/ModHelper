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

	public function __construct($flags = 0)
	{
		$this->flags == Sanitizer::sanitizeInt($flags, 0x0, 0x80000000);
	}

	/*
	 * Returns the stored bits.
	 *
	 * @access protected
	 * @return int
	 */
    public function __toString()
    {
        return (string) $this->flags;
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
