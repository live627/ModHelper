<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @since 1.1
 * @version 2.0
 */
class Linktree
{
    protected $collection;

    public function execute()
    {
        global $context;

        foreach ($this->collection as list ($name, $url, $before, $after)) {
            $item = array(
                'name' => $name,
            );
            if ($url !== null)
                $item['url'] = $url;
            if ($before !== null)
                $item['extra_before'] = $before;
            if ($after !== null)
                $item['extra_after'] = $after;

            $context['linktree'][] = $item;
        }
    }

    public function add($name, $url = null, $before = null, $after = null)
    {
        $this->collection->add([$name, $url, $before, $after]);

        return $this;
    }

    public function __construct(Set $collection, array $links)
    {
        $this->collection = new $collection;

        foreach ($links as list ($name, $url, $before, $after)) {
            $this->add($name, $url, $before, $after);
        }

        return $this;
    }

}
