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
        if (session_status() === PHP_SESSION_DISABLED) {
            throw new RuntimeException('PHP sessions are disabled');
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new RuntimeException('Failed to start the session: already started by PHP.');
        }
            $_SERVER['REMOTE_ADDR'] = 'ModHelper Test Suite';
            $_SERVER['HTTP_USER_AGENT'] = 'ModHelper';
            $hash = $this->loader->generate();
        $_POST[$this->loader->getKey()] = $hash;
        $actual = $this->loader->check();
        $this->assertTrue($actual);
    }
}
