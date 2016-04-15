<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @version 2.0
 */

class Ohara extends \Suki\Ohara
{
    protected $file;

    public function __construct($file)
    {
        $this->setRegistry();
        $this->file = $file;
    }

    /**
     * Loads the extending class language file and sets a new key in {@link $_text}
     * Ohara automatically adds the value of {@link $var} plus an underscore to match the exact $txt key when fetching the var
     * @access protected
     * @param string $var The name of the $txt key you want to retrieve
     * @return string
     */
    protected function setText($var)
    {
        global $txt;

        if (empty($var)) {
            return false;
        }
        // Load the mod's language file.
        loadLanguage($this->name);
        if (!empty($txt[$this->name . '_' . $var])) {
            $this->_text[$var] = $txt[$this->name . '_' . $var];
        } elseif (!empty($txt[$var])) {
            $this->_text[$var] = $txt[$var];
        } else {
            $this->_text[$var] = false;
        }
    }

    /**
     * Checks the var against {@link $_request} to know if it exists and its defined or not.
     * calls Ohara::setData() in case {@link $_request} is empty by the time this method its called
     * @param string $var the superglobal's key name you want to check
     * @access public
     * @return boolean
     */
    public function validate($var)
    {
        if (empty($this->_request)) {
            $this->setData();
        }

        return isset($this->_request[$var]);
    }

    /**
     * Gets a mod's config file, loads it and store it on {@link $_config}
     * @access public
     * @return array
     */
    protected function getConfigFile()
    {
        if (!empty(static::$_config[$this->name])) {
            return static::$_config[$this->name];
        }
        try
        {
            return static::$_config[$this->name] = new \Dragooon\YamlFileConfig\YamlFileConfig($file);
        }
        catch (\Exception $e)
        {
            fatal_error($e->getMessage());
        }
    }
}
