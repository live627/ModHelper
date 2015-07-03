<?php

namespace ModHelper;

/**
 * Nonce, an anti CSRF token generation/checking class.
 * Copyright (c) 2011 Thibaut Despoulain <http://bkcore.com/blog/code/nocsrf-php-class.html>
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @version 1.0
 */
class Nonce
{
	/**
	 * @var string
	 */
	private $hash;

	protected $doOriginCheck = false;
	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var int
	 */
	private $ttl = 900;

	/**
	 * Check CSRF tokens match between session and $origin.
	 * Make sure you generated a token in the form before checking it.
	 *
	 * @param String $key The session and $origin key where to find the token.
	 * @param Mixed $origin The object/associative array to retreive the token data from (usually $_POST).
	 * @param Boolean $throwException (Facultative) TRUE to throw exception on check fail, FALSE or default to return false.
	 * @param Integer $timespan (Facultative) Makes the token expire after $timespan seconds. (null = never)
	 * @param Boolean $multiple (Facultative) Makes the token reusable and not one-time. (Useful for ajax-heavy requests).
	 *
	 * @return Boolean Returns FALSE if a CSRF attack is detected, TRUE otherwise.
	 */
	public function check($key, $origin, $throwException = false, $timespan = null, $multiple = false)
	{
		if (!isset($_SESSION['csrf_' . $this->key])) {
			throw new Exception('Missing CSRF session token.');
		}

		if (!isset($_POST[$this->key])) {
			throw new Exception('Missing CSRF form token.');
		}

		// Get valid token from session
		$hash = $_SESSION['csrf_' . $key];

		// Free up session token for one-time CSRF token usage.
		if (!$multiple) {
			$_SESSION['csrf_' . $key] = null;
		}

		// Origin checks
		if ($this->originCheck && sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) != substr(base64_decode($this->hash), 10, 40)) {
			throw new Exception('Form origin does not match token origin.');
		}

		// Check if session token matches form token
		if ($_POST[$this->key] != $this->hash) {
			throw new Exception('Invalid CSRF token.');
		}

		// Check for token expiration
		if ($this->ttl != null && is_int($this->ttl) && intval(substr(base64_decode($this->hash), 0, 10)) + $this->ttl < time()) {
			throw new Exception('CSRF token has expired.');
		}

		return true;
	}

	/**
	 * Adds extra useragent and remote_addr checks to CSRF protections.
	 */
	public function enableOriginCheck()
	{
		self::$doOriginCheck = true;
	}

	/**
	 * CSRF token generation method. After generating the token, put it inside a hidden form field named $key.
	 *
	 * @param String $key The session key where the token will be stored. (Will also be the name of the hidden field name)
	 * @return String The generated, base64 encoded token.
	 */
	public function generate($key)
	{
		$extra = self::$doOriginCheck ? sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) : '';
		// token generation (basically base64_encode any random complex string, time() is used for token expiration)
		$token = base64_encode(time() . $extra . self::randomString(32));
		// store the one-time token in session
		$_SESSION['csrf_' . $key] = $token;

		return $token;
	}

	/**
	 * Generates a random string of given $length.
	 *
	 * @param Integer $length The string length.
	 * @return String The randomly generated string.
	 */
	protected function randomString($length)
	{
		$seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
		$max = strlen($seed) - 1;

		$string = '';
		for ($i = 0; $i < $length; ++$i) {
			$string .= $seed{intval(mt_rand(0.0, $max))};
		}

		return $string;
	}

}

?>
