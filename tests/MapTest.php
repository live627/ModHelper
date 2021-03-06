<?php

namespace ModHelper\Tests;

use ModHelper\Map;
use ModHelper\Set;

class MapTest extends \PHPUnit_Framework_TestCase {

    public function testAddGetRemove() {
        $key1 = 'key1';
        $key2 = 'key2';
        $key3 = 'key3';
        $item1 = 'item 1';
        $item2 = 'item 2';
        $item3 = 'item 3';
        $items = [$key1 => $item1, $key2 => $item2];
        $keys = new Set([$key1, $key2]);
        $values = new Set([$item1, $item2]);

        $map = new Map();
        $map->set($key1, $item1);

        $this->assertCount(1, $map);
        $this->assertEquals($item1, $map->get($key1));
        $this->assertTrue($map->has($key1));
        $this->assertFalse($map->has($key2));

        $map->remove($key1);

        $this->assertCount(0, $map);

        $map->setAll($items);

        $this->assertCount(2, $map);
        $this->assertEquals($keys, $map->keys());
        $this->assertEquals($values, $map->values());

        $map->set($key3, $item3);

        $this->assertCount(3, $map);

        $map->clear();
        $this->assertCount(0, $map);

        $dupKeyItems = [$key1 => $item1, $key2 => $item2];
        $map->setAll($dupKeyItems);
        $map->set($key2, $item3);

        $this->assertCount(2, $map);
        $this->assertEquals($item3, $map->get($key2));

        $this->assertEmpty($map->get('non_existing_key'));
        $this->assertEmpty($map->remove('non_existing_key'));
    }

    public function testToArray() {
        $key1 = 'key1';
        $key2 = 'key2';
        $key3 = 'key3';
        $item1 = 'item 1';
        $item2 = 'item 2';
        $item3 = 'item 3';
        $items = [$key1 => $item1, $key2 => $item2, $key3 => $item3];

        $map = new Map($items);
        $this->assertSame($items, $map->toArray());
    }

    public function testMap() {
        $map = new Map(['a' => 'a', 'b' => 'b', 'c' => 'c']);
        $map2 = $map->map(function ($item) {
            return $item . 'val';
        });

        $this->assertSame(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map2->toArray());
    }

    public function testFilter() {
        $map = new Map(['a' => 'a', 'b' => 'b', 'c' => 'c']);
        $map2 = $map->filter(function ($item) {
            return $item != 'b';
        });

        $this->assertSame(['a' => 'a', 'c' => 'c'], $map2->toArray());
    }

    public function testArrayAccess() {
        $map = new Map();
        $map['a'] = 'b';

        $this->assertCount(1, $map);
        $this->assertTrue($map->has('a'));
        $this->assertFalse($map->has('c'));
        $this->assertTrue($map->contains('b'));
        $this->assertFalse($map->contains('c'));
        $this->assertEquals($map['a'], $map->get('a'));
        $this->assertTrue(isset($map['a']));
        $this->assertFalse(isset($map['c']));

        $map['a'] = 'x';

        $this->assertEquals('x', $map['a']);

        unset($map['a']);

        $this->assertFalse($map->has('a'));
        $this->assertCount(0, $map);

    }
}