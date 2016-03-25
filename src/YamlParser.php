<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @version 2.0
 */

use \Symfony\Component\Yaml\Parser;
use \Symfony\Component\Yaml\Dumper;
use \Symfony\Component\Yaml\Exception\ParseException;

class YamlParser
{
    private $parser;
    private $data;


    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function __invoke($filePath)
    {
        try {
            $this->data = $yaml->parse(file_get_contents($filePath));
        }
        catch (ParseException $e) {
            throw new Exceptions\YamlParserException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Appends a value to the object
     *
     * This method is chainable.
     *
     * @param mixed The value to set
     * @access public
     * @since 2.0
     */
    public function add($item)
    {
        $this->data[] = $item;
        return $this;
    }

    function __toString()
    {
        $dumper = new Dumper();
        return $dumper->dump($this->data, 2);
    }

    public function put($filePath)
    {
        file_put_contents($filePath, $this)
    }
}