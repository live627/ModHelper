<?php

namespace ModHelper;

/**
 * Nonce, an anti CSRF token generation/checking class.
 * Copyright (c) 2011 Thibaut Despoulain <http://bkcore.com/blog/code/nocsrf-php-class.html>
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.1
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
		if (!isset($key)) {
			$this->key = 'csrf_' . bin2hex(random_bytes(8));
		}
		if (!is_int($ttl)) {
			throw new \InvalidArgumentException('Integer expected: $ttl');
		}
		$this->ttl = $ttl;
	}
	/**
	 * Check CSRF tokens match between session and $origin.
	 * Make sure you generated a token in the form before checking it.
	 *
	 * @return bool Returns false if a CSRF attack is detected, true otherwise.
	 */
	public function check()
	{
		$this->hash = Session::get($this->key);
		if ($this->hash === false) {
			throw new Exceptions\MissingDataException('Missing CSRF session token');
		}

		if (!isset($_POST[$this->key])) {
			throw new Exceptions\MissingDataException('Missing CSRF form token');
		}

		// Origin checks
		if (sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) != substr(base64_decode($this->hash), 10, 40)) {
			throw new Exceptions\BadCombinationException('Form origin does not match token origin.');
		}

		// Check if session token matches form token
		if ($_POST[$this->key] != $this->hash) {
			throw new Exceptions\BadCombinationException('Invalid CSRF token');
		}

		// Check for token expiration
		if ($this->ttl != null && is_int($this->ttl) && intval(substr(base64_decode($this->hash), 0, 10)) + $this->ttl < time()) {
			throw new \RangeException('CSRF token has expired.');
		}

		// Free up session token for one-time CSRF token usage.
		Session::pull($this->key);

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
		if (!is_int($ttl)) {
			throw new \InvalidArgumentException('Integer expected: $ttl');
		}
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
		$this->hash = base64_encode(time() . sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) . bin2hex(random_bytes(32)));
		Session::put($this->key, $this->hash);
		return $this->hash;
	}
}
