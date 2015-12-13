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
        $this->assertInstanceOf('StarCitizen\Models\Profile', Accounts::find("MrChance"));
    }

    public function testThreads()
    {
        $thread_ids = [];

        $threads = Accounts::find("Jethro_E7",Accounts::THREADS);
        $this->assertInstanceOf('StarCitizen\Models\Threads', $threads);
        foreach ($threads as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
            $thread_ids[] = $thread->thread_id;
        }


        $this->assertTrue($threads->offsetExists($thread_ids[0]));
        $thread = $threads->offsetGet($thread_ids[0]);
        $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
    }

    public function testBadMethod()
    {
        $this->setExpectedException('BadFunctionCallException', "methodDoesNotExist doesn't exist in this class, client not checked");
        Accounts::methodDoesNotExist();
    }


}