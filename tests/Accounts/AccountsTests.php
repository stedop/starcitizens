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
    public function testGetAccount()
    {
        $this->assertEquals("get called",Accounts::get("TheMrChance"));
        $this->setExpectedException("BadFunctionCallException", "functionName doesn't exist in this class, client not checked");
        Accounts::functionName();
    }
}