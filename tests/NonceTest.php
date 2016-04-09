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
        catch (\Exception $e)
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

    public function testKey()
    {
        $actual = $this->loader->getKey();
        $this->assertContains('csrf_', $actual);
        
        $this->loader->setKey('trolololol');      
        $actual = $this->loader->getKey();
        $this->assertSame('trolololol', $actual);
    }

    public function testTtl()
    {
        $actual = $this->loader->getTtl();
        $this->assertSame(900, $actual);
        
        $this->loader->setTtl(90);      
        $actual = $this->loader->getTtl();
        $this->assertSame(90, $actual);
    }

    public function testAttack()
    {
        if (session_status() === PHP_SESSION_DISABLED) {
            throw new RuntimeException('PHP sessions are disabled');
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new RuntimeException('Failed to start the session: already started by PHP.');
        }
        $actual = $this->loader->checkAttack();
        $this->assertSame('Missing CSRF session token', $actual);

        $_SESSION[$this->loader->getKey()] = true;
        $actual = $this->loader->checkAttack();
        $this->assertSame('Missing CSRF form token', $actual);

        $_SERVER['REMOTE_ADDR'] = 'ModHelper Test Suite';
        $_SERVER['HTTP_USER_AGENT'] = 'ModHelper';
        $hash = $this->loader->generate();
        $_SERVER['REMOTE_ADDR'] = '';
        $_SERVER['HTTP_USER_AGENT'] = '';
        $_POST[$this->loader->getKey()] = true;
        $actual = $this->loader->checkAttack();
        $this->assertSame('Form origin does not match token origin.', $actual);

        $_SERVER['REMOTE_ADDR'] = 'ModHelper Test Suite';
        $_SERVER['HTTP_USER_AGENT'] = 'ModHelper';
        $actual = $this->loader->checkAttack();
        $this->assertSame('Invalid CSRF token', $actual);

        $_POST[$this->loader->getKey()] = $hash;
        $this->loader->setTtl(-90);  
        $actual = $this->loader->checkAttack();
        $this->assertSame('CSRF token has expired.', $actual);
        
        $this->loader->setTtl(90);  
        $actual = $this->loader->check();
        $this->assertTrue($actual);
    }
}
