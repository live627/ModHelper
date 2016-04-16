<?php

namespace ModHelper\Tests;

use ModHelper\Set;

class SetTest extends \PHPUnit_Framework_TestCase {

    public function testAddRemove() {
        $item1 = 'item 1';
        $item2 = 'item 2';
        $item3 = 'item 3';
        $items = [$item1, $item2];

        $set = new Set();
        $set->add($item1);

        $this->assertCount(1, $set);

        $set->remove($item1);

        $this->assertCount(0, $set);

        $set->addAll($items);

        $this->assertCount(2, $set);
        $this->assertSame($items, $set->values()->toArray());

        $set->add($item3);

        $this->assertCount(3, $set);

        $set->removeAll($items);

        $this->assertCount(1, $set);

        $set->addAll($items);
        $this->assertFalse($set->isEmpty());
        $set->clear();
        $this->assertTrue($set->isEmpty());
    }

    public function testDuplicateValues() {
        $item1 = 'item 1';

        $set = new Set();
        $set->add($item1)->add($item1)->add($item1);

        $this->assertCount(1, $set);
    }

    public function testContains() {
        $item1 = 'item 1';
        $item2 = 'item 2';
        $item3 = 'item 3';
        $items = [$item1, $item2];

        $set = new Set($items);

        $this->assertTrue($set->contains($item2));
        $this->assertFalse($set->contains($item3));
    }

    public function testMap() {
        $set = new Set([2, 3, 4]);
        $set2 = $set->map(function ($item) {
            return $item * $item;
        });

        $this->assertSame([4, 9, 16], $set2->toArray());
    }

    public function testFilter() {
        $set = new Set([1, 2, 3, 4, 5, 6]);
        $set2 = $set->filter(function ($item) {
            return $item & 1;
        });

        $this->assertSame([1, 3, 5], $set2->toArray());
    }
}