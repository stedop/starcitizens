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
        $this->assertFalse(Accounts::findProfile("TheMrChance"));
        $this->assertInstanceOf('StarCitizen\Models\Profile', Accounts::findProfile("MrChance"));
    }

    public function testThreads()
    {
        $thread_ids = [];

        $threads = Accounts::findThreads("Jethro_E7",Accounts::THREADS);
        $this->assertInstanceOf('StarCitizen\Models\Threads', $threads);
        foreach ($threads as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
            $thread_ids[] = $thread->thread_id;
        }

        // Testing offset exists
        $this->assertTrue($threads->offsetExists($thread_ids[0]));

        // Testing offset get
        $thread = $threads->offsetGet($thread_ids[0]);
        $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);

        // Testing magic get
        $thread = $threads->$thread_ids[0];
        $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);

        // Testing magic set
        $countBeforeAdd = $threads->count();
        $newThread = clone $thread;
        $newId = '999';
        $newThread->thread_id = $newId;
        $threads->$newId = $newThread;

        // Test count
        $this->assertTrue($countBeforeAdd < count($threads));

        // Test Iterator
        $iterator = $threads->getIterator();
        $this->assertInstanceOf('ArrayIterator', $iterator);

        // Test unset
        $threads->offsetUnset('999');
        $this->assertFalse($threads->offsetExists('999'));

    }

    public function testBadMethod()
    {
        $this->setExpectedException('BadFunctionCallException', "methodDoesNotExist doesn't exist in this class, client not checked");
        Accounts::methodDoesNotExist();
    }


}