<?php

namespace ModHelper\Tests;

class Thing extends \ModHelper\Enum
{
    const FOO = 'foo';
    const BAR = 'bar';
    const NUMBER = 42;
    const PROBLEMATIC_NUMBER = 0;
    const PROBLEMATIC_NULL = null;
    const PROBLEMATIC_EMPTY_STRING = '';
    const PROBLEMATIC_BOOLEAN_FALSE = false;
}

class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValue()
    {
        $value = new Thing(Thing::FOO);
        $this->assertEquals(Thing::FOO, $value->getValue());

        $value = new Thing(Thing::BAR);
        $this->assertEquals(Thing::BAR, $value->getValue());

        $value = new Thing(Thing::NUMBER);
        $this->assertEquals(Thing::NUMBER, $value->getValue());
    }

    public function testGetKey($value, $expected)
    {
        $value = new Thing(Thing::FOO);
        $this->assertEquals('FOO', $value->getKey());
        $this->assertNotEquals('BA', $value->getKey());
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function testCreatingEnumWithInvalidValue($value)
    {
        $this->setExpectedException(
            '\UnexpectedValueException',
            'Value \'' . $value . '\' is not part of the enum ModHelper\Tests\Thing'
        );

        new Thing($value);
    }

    public function invalidValueProvider() {
        return array(
            'string' => array('test'),
            'int' => array(1234),
        );
    }

    /**
     * @dataProvider toStringProvider
     */
    public function testToString($expected, $enumObject)
    {
        $this->assertSame($expected, (string) $enumObject);
    }

    public function toStringProvider() {
        return array(
            array(Thing::FOO, new Thing(Thing::FOO)),
            array(Thing::BAR, new Thing(Thing::BAR)),
            array((string) Thing::NUMBER, new Thing(Thing::NUMBER)),
        );
    }

    public function testKeys()
    {
        $values = Thing::keys();
        $expectedValues = array(
            'FOO',
            'BAR',
            'NUMBER',
            'PROBLEMATIC_NUMBER',
            'PROBLEMATIC_NULL',
            'PROBLEMATIC_EMPTY_STRING',
            'PROBLEMATIC_BOOLEAN_FALSE',
        );

        $this->assertSame($expectedValues, $values);
    }

    public function testValues()
    {
        $values = Thing::values();
        $expectedValues = array(
            'FOO'                       => new Thing(Thing::FOO),
            'BAR'                       => new Thing(Thing::BAR),
            'NUMBER'                    => new Thing(Thing::NUMBER),
            'PROBLEMATIC_NUMBER'        => new Thing(Thing::PROBLEMATIC_NUMBER),
            'PROBLEMATIC_NULL'          => new Thing(Thing::PROBLEMATIC_NULL),
            'PROBLEMATIC_EMPTY_STRING'  => new Thing(Thing::PROBLEMATIC_EMPTY_STRING),
            'PROBLEMATIC_BOOLEAN_FALSE' => new Thing(Thing::PROBLEMATIC_BOOLEAN_FALSE),
        );

        $this->assertEquals($expectedValues, $values);
    }

    public function testToArray()
    {
        $values = Thing::toArray();
        $expectedValues = array(
            'FOO'                   => Thing::FOO,
            'BAR'                   => Thing::BAR,
            'NUMBER'                => Thing::NUMBER,
            'PROBLEMATIC_NUMBER'    => Thing::PROBLEMATIC_NUMBER,
            'PROBLEMATIC_NULL'      => Thing::PROBLEMATIC_NULL,
            'PROBLEMATIC_EMPTY_STRING'    => Thing::PROBLEMATIC_EMPTY_STRING,
            'PROBLEMATIC_BOOLEAN_FALSE'    => Thing::PROBLEMATIC_BOOLEAN_FALSE,
        );

        $this->assertSame($expectedValues, $values);
    }

    public function testStaticAccess()
    {
        $this->assertEquals(new Thing(Thing::FOO), Thing::FOO());
        $this->assertEquals(new Thing(Thing::BAR), Thing::BAR());
        $this->assertEquals(new Thing(Thing::NUMBER), Thing::NUMBER());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage No static method or enum constant 'UNKNOWN' in class
     *                           UnitTest\ModHelper\Enum\Thing
     */
    public function testBadStaticAccess()
    {
        Thing::UNKNOWN();
    }

    /**
     * @dataProvider isValidProvider
     */
    public function testIsValid($value, $isValid)
    {
        $this->assertSame($isValid, Thing::isValid($value));
    }

    public function isValidProvider() {
        return array(
            array('foo', true),
            array(42, true),
            array(null, true),
            array(0, true),
            array('', true),
            array(false, true),
            array('baz', false)
    );
    }

    public function testIsValidKey()
    {
        $this->assertTrue(Thing::isValidKey('FOO'));
        $this->assertFalse(Thing::isValidKey('BAZ'));
    }
}
