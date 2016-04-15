<?php

namespace ModHelper\Interfaces;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 2.0
 */
interface Collection extends \Countable, \IteratorAggregate
{
    /**
     * The array that holds all the items collected by the object.
     *
     * @var array
     * @access private
     */
    private $items = array();
}