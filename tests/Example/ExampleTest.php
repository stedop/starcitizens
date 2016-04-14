<?php

namespace StarCitizen\Tests\Example;

use StarCitizen\Accounts\Accounts;
use StarCitizen\StarCitizens;

/**
 * Class ExampleTest
 * @package Tests\Example
 */
class ExampleTest extends \PHPUnit_Framework_TestCase {
    
    public function testReddit()
    {
        $profile = Accounts::findProfile('MrChance');
        $this->assertTrue($profile->isRedditor());
    }
}