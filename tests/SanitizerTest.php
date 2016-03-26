<?php

namespace ModHelper\Tests;

use \ModHelper\Sanitizer;

$smcFunc = [
    'htmlspecialchars' => function ($string, $quote_style = ENT_COMPAT)
    {
        return htmlspecialchars($string, $quote_style);
    },
    'htmltrim' => function ($string) 
    {
        return trim($string);
    },
    'strlen' => function ($string) 
    {
        return strlen($string);
    }
];

class SanitizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNotInt()
    {
        Sanitizer::sanitizeInt([0x10]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMinNotInt()
    {
        Sanitizer::sanitizeInt(0x10, [0x0]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMaxNotInt()
    {
        Sanitizer::sanitizeInt(0x10, 0x0, [0x8]);
    }

    /**
     * @expectedException \RangeException
     */
    public function testTooBig()
    {
        Sanitizer::sanitizeInt(0x10, 0x0, 0x8);
    }

    /**
     * @expectedException \RangeException
     */
    public function testTooSmall()
    {
        Sanitizer::sanitizeInt(0x1, 0x4, 0x8);
    }

    public function testInRange()
    {
        $this->assertSame(0x4, Sanitizer::sanitizeInt(0x4, 0x0, 0x8));
    }

    public function testEmail()
    {
        $this->assertTrue(Sanitizer::sanitizeEmail('live627@gmail.com'));
    }

    public function testText()
    {
        $this->assertSame('1&amp;2', Sanitizer::sanitizeText('1&2'));
    }
}
