<?php

namespace ModHelper\Tests;

class MockBitwiseFlag extends \ModHelper\BitwiseFlag
{
    const FLAG_REGISTERED = 0x1; // BIT #1 of $flags has the value 1
    const FLAG_ACTIVE = 0x2;         // BIT #2 of $flags has the value 2
    const FLAG_MEMBER = 0x4;         // BIT #3 of $flags has the value 4
    const FLAG_ADMIN = 0x8;            // BIT #4 of $flags has the value 8

    public function isRegistered(){
        return $this->isFlagSet(self::FLAG_REGISTERED);
    }

    public function isActive(){
        return $this->isFlagSet(self::FLAG_ACTIVE);
    }

    public function isMember(){
        return $this->isFlagSet(self::FLAG_MEMBER);
    }

    public function isAdmin(){
        return $this->isFlagSet(self::FLAG_ADMIN);
    }

    public function setRegistered($value){
        $this->setFlag(self::FLAG_REGISTERED, $value);
    }

    public function setActive($value){
        $this->setFlag(self::FLAG_ACTIVE, $value);
    }

    public function setMember($value){
        $this->setFlag(self::FLAG_MEMBER, $value);
    }

    public function setAdmin($value){
        $this->setFlag(self::FLAG_ADMIN, $value);
    }

    function __toStringt()
    {
        return $this->flags;
    }
}

class BitwiseFlagTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    protected function setUp()
    {
        $this->loader = new MockBitwiseFlag;

        $this->loader->setRegistered(true);
        $this->loader->setActive(true);
        $this->loader->setMember(true);
    }

    public function testInitialSet()
    {
        $actual = $this->loader->isRegistered();
        $this->assertTrue($actual);

        $actual = $this->loader->isActive();
        $this->assertTrue($actual);

        $actual = $this->loader->isMember();
        $this->assertTrue($actual);

        $actual = $this->loader->isAdmin();
        $this->assertFalse($actual);
    }

    public function testRawBits()
    {
        $this->assertSame(0x7, (string) $this->loader);
    }
}
