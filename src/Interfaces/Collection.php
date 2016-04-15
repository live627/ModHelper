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
    function contains($item);

    function remove($item);
}