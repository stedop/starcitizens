<?php

namespace StarCitizen\Tests\Accounts;
use StarCitizen\Accounts\Accounts;

/**
 * Class AccountsTest
 *
 * @package Accounts;
 */
class AccountsTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Accounts::get()
     * @covers ClientAwareTrait::setupClient
     * @covers ClientAwareTrait::__callStatic
     */
    public function testGetAccount()
    {
        $this->assertEquals("get called",Accounts::get());
        $this->setExpectedException("BadFunctionCallException", "functionName doesn't exist in this class, client not checked");
        Accounts::functionName();
    }
}