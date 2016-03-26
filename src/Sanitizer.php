<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.1
 */
class Sanitizer
{
	public static function sanitizeSlug($var)
	{
		// We don't do htmlspecialchars because we have different plans for it.
		// In fact, we just start with stripping easy cases - convert space or _ to - and lowercase it.
		$var = strtolower(strtr($var, array(' ' => '-', '_' => '-')));
		// Strip all the characters we don't accept - we accept the following: a-z0-9%-
		$var = preg_replace('~[^a-z0-9%-]+~', '', $var);
		// Strip duplicates
		$var = preg_replace('~\-+~', '-', $var);
		// Lastly, cap to 50 characters and trim any leading or trailing stuff
		$var = trim(substr($var, 0, 50), '-');

		return $var;
	}

	public static function sanitizeUrl($var)
	{
		// Soft-fix domains without any kind of schema, because users may not be nice about it.
		if (substr($var, 0, 7) !== 'http://' && substr($var, 0, 8) !== 'https://') {
			$var = (substr($var, 0, 2) == '//' ? 'http:' : 'http://') . $var;
		}

		return filter_var(trim($var), FILTER_VALIDATE_URL);
	}

	public static function sanitizeText($var, $max_length = null)
	{
		global $smcFunc;
		$content = $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($var), ENT_QUOTES);
		if (!empty($content) && $max_length !== null) {
			$content = $smcFunc['substr']($content, 0, $max_length);
		}

		return $content;
	}

	public static function sanitizeBBCText($var, $max_length)
	{
		global $sourcedir;
		require_once($sourcedir . '/Subs-Post.php');
		$var = self::sanitizeText($var, $max_length);
		preparsecode($var);

		return $var;
	}

	/**
	 * @param integer $var
	 * @param integer $min
	 * @param integer $max
	 */
	public static function sanitizeInt($var, $min = null, $max = null)
	{
		if (!is_int($var)) {
			throw new InvalidArgumentException('$var is expeceted to be an integer');
		}
		$var = (int) $var;
		if (!empty($min) && !empty($max)) {
			if (!is_int($min)) {
				throw new \InvalidArgumentException('$min is expeceted to be an integer');
			}
			if (!is_int($max)) {
				throw new \InvalidArgumentException('$max is expeceted to be an integer');
			}
			if (filter_var($var, FILTER_VALIDATE_INT, ['min_range' => $min, 'max_range' => $max])) {
				throw new \RangeException('$var is outside the xpected range (' . $min  . ', ' . $max . ')');
			}
			return max(min($val, $max), $min);
		}

		return $var;
	}

	public static function sanitizeEmail($var)
	{
		global $txt;
		$sanitized = filter_var(self::sanitizeText($var), FILTER_VALIDATE_EMAIL);
		isBannedEmail($sanitized, 'cannot_post', sprintf($txt['you_are_post_banned'], $txt['guest_title']));
		return $sanitized;
	}
}
