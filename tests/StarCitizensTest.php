<?php

namespace StarCitizen\Tests;

use StarCitizen\StarCitizens;

/**
 * Class StarCitizensTest
 */
class StarCitizensTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \StarCitizen\StarCitizens
     */
    public $starCitizens;

    public function setUp()
    {
        $this->starCitizens = new StarCitizens();
    }

    public function testExceptions()
    {
        $this->expectException(\Exception::class);
        $response = $this->starCitizens->notHere('MrChance');
    }

    public function testFind()
    {
        $response = $this->starCitizens->accounts('MrChance');
        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertInstanceOf('StarCitizen\Models\Profile',$response);
    }

    public function testFullFind()
    {
        $response = $this->starCitizens->accounts('Jethro_E7', 'threads');
        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertInstanceOf('StarCitizen\Models\Store',$response);
        foreach ($response as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread',$thread);
        }
    }

    public function testStatic()
    {
        $response = StarCitizens::accounts('MrChance');
        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertInstanceOf('StarCitizen\Models\Profile',$response);
    }
}