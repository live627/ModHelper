<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.1
 */
class Session
{
    /**
     * Add value to a session
     * @param string $key   name the data to save
     * @param string $value the data to save
     */
    public static function put($key, $value = false)
    {
        /**
        * Check whether session is set in array or not
        * If array then set all session key-values in foreach loop
        */
        if (is_array($key) && $value === false) {
            foreach ($key as $name => $value) {
                $_SESSION[$name] = $value;
            }
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * extract item from session then delete from the session, finally return the item
     * @param  string $key item to extract
     * @return string      return item
     */
    public static function pull($key)
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }

    /**
     * get item from session
     *
     * @param  string  $key       item to look for in session
     * @param  boolean $secondkey if used then use as a second key
     * @return string             returns the key
     */
    public static function get($key, $secondkey = false)
    {
        if ($secondkey !== false) {
            if (isset($_SESSION[$key][$secondkey])) {
                return $_SESSION[$key][$secondkey];
            }
        } else {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
        return false;
    }

    /**
     * return the session array
     * @return array of session indexes
     */
    public function __toString()
    {
        return print_r($_SESSION);
    }
}
