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
		finally {
					//This overrides the exception as if it were never thrown
		return $result;
		}

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
        $actual = $this->loader->checkAttack();
        $this->assertSame('Missing CSRF session token', $actual);

        $hash = $this->loader->generate();
        $actual = $this->loader->checkAttack();
        $this->assertSame('Missing CSRF form token', $actual);

        $_POST[$this->loader->getKey()] = true;
        $actual = $this->loader->checkAttack();
        $this->assertSame('Invalid CSRF token' , $actual);

        $_POST[$this->loader->getKey()] = $hash;
        $actual = $this->loader->checkAttack();
        $this->assertSame('CSRF check passed' , $actual);
    }
}
