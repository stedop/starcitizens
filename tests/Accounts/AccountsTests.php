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
        $this->assertFalse(Accounts::find("TheMrChance"));
        $this->assertInstanceOf('StarCitizen\Accounts\Profile', Accounts::find("MrChance"));
    }
}