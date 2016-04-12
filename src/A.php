<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 * @version 1.2
 */

abstract class A
{
    static function init()
    {
        return new static();
    }
}
