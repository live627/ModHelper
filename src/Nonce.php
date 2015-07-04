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

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var int
	 */
	private $ttl = 900;

	/**
	 * @param string $key The session and $origin key where to find the token.
	 * @param int $ttl (Facultative) Makes the token expire after $this->ttl seconds. (null = never)
	 */
	public function __construct($key = null, $ttl = 900)
	{
		if (!isset($this->key)) {
			$this->key = $this->randomString(8);
		}
		$this->ttl = $ttl;
	}
	/**
	 * Check CSRF tokens match between session and $origin.
	 * Make sure you generated a token in the form before checking it.
	 *
	 * @return bool Returns FALSE if a CSRF attack is detected, TRUE otherwise.
	 */
	public function check()
	{
		if (!isset($_SESSION['csrf_' . $this->key])) {
			throw new Exceptions\MissingDataException('Missing CSRF session token.');
		}

		if (!isset($_POST[$this->key])) {
			throw new Exceptions\MissingDataException('Missing CSRF form token.');
		}

		// Get valid token from session
		$this->hash = $_SESSION['csrf_' . $this->key];

		// Free up session token for one-time CSRF token usage.
		$_SESSION['csrf_' . $this->key] = null;

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
			throw new \RangeException('CSRF token has expired.');
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @param string $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param int $ttl
	 */
	public function setTtl($ttl)
	{
		$this->ttl = $ttl;
	}

	/**
	 * @return int
	 */
	public function getTtl()
	{
		return $this->ttl;
	}

	/**
	 * CSRF token generator. After generating the token, put it inside a hidden form field named $this->key.
	 *
	 * @return string The generated, base64 encoded token.
	 */
	public function generate()
	{
		// token generation (basically base64_encode any random complex string, time() is used for token expiration)
		return $_SESSION['csrf_' . $this->key] = $this->hash = base64_encode(time() . sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) . $this->randomString(32));
	}

	/**
	 * Generates a random string of given $length.
	 *
	 * @param int $length The string length.
	 * @return string The randomly generated string.
	 */
	private function randomString($length)
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

