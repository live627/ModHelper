<?php

namespace ModHelper\Tests;

class MockNonce extends \ModHelper\Nonce
{
    public function checkAttack()
    {
        try
        {
            $this->check();
            $result = 'CSRF check passed';
        }
        catch (Exception $e)
        {
            // CSRF attack detected
            $result = $e->getMessage();
        }
        return $result;
    }
}

class NonceTest extends \PHPUnit_Framework_TestCase
{
    protected $loader;

    protected function setUp()
    {
        $this->loader = new MockNonce;
    }

    public function testTtl()
    {
        $actual = $this->loader->getTtl();
        $this->assertSame(900, $actual);
    }

    public function testAttack()
    {
        try
        {
            $this->loader->check();
        }
        catch (Exception $e)
        {
            $this->assertSame('Missing CSRF session token', $e->getMessage());
        }

        try
        {
            $_SERVER['REMOTE_ADDR'] = 'ModHelper Test Suite';
            $_SERVER['HTTP_USER_AGENT'] = 'ModHelper';
            $hash = $this->loader->generate();
            $this->loader->check();
        }
        catch (Exception $e)
        {
            $this->assertSame('Missing CSRF form token', $e->getMessage());
        }

        try
        {
            $_POST[$this->loader->getKey()] = true;
            $this->loader->check();
        }
        catch (Exception $e)
        {
            $this->assertSame('Invalid CSRF token' , $e->getMessage());
        }

        $_POST[$this->loader->getKey()] = $hash;
        $actual = $this->loader->check();
        $this->assertTrue($actual);
    }
}
