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

        $threads = Accounts::findThreads("Jethro_E7");
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

    public function testPosts()
    {
        $post_ids = [];

        $posts = Accounts::findPosts("Jethro_E7");
        $this->assertInstanceOf('StarCitizen\Models\Posts', $posts);
        foreach ($posts as $post) {
            $this->assertInstanceOf('StarCitizen\Models\Post', $post);
            $post_ids[] = $post->post_id;
        }

        // Testing offset exists
        $this->assertTrue($posts->offsetExists($post_ids[0]));

        // Testing offset get
        $post = $posts->offsetGet($post_ids[0]);
        $this->assertInstanceOf('StarCitizen\Models\Post', $post);

        // Testing magic get
        $post = $posts->$post_ids[0];
        $this->assertInstanceOf('StarCitizen\Models\Post', $post);

        // Testing magic set
        $countBeforeAdd = $posts->count();
        $newThread = clone $post;
        $newId = '999';
        $newThread->thread_id = $newId;
        $posts->$newId = $newThread;

        // Test count
        $this->assertTrue($countBeforeAdd < count($posts));

        // Test Iterator
        $iterator = $posts->getIterator();
        $this->assertInstanceOf('ArrayIterator', $iterator);

        // Test unset
        $posts->offsetUnset('999');
        $this->assertFalse($posts->offsetExists('999'));
    }

    public function testCurrying()
    {
        $account = Accounts::findProfile("jethro_e7");
        $this->assertInstanceOf('StarCitizen\Models\Profile', $account);

        foreach ($account->threads() as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
        }

        $this->assertInstanceOf('StarCitizen\Models\Threads', $account->threads);

        foreach ($account->posts() as $post) {
            $this->assertInstanceOf('StarCitizen\Models\Post', $post);
        }

        $this->assertInstanceOf('StarCitizen\Models\Threads', $account->threads);
        $this->assertInstanceOf('StarCitizen\Models\Posts', $account->posts);
    }

    public function testWith()
    {
        $account = Accounts::findProfile("jethro_e7")->with('posts', 'Threads', 'doesNotExist');
        $this->assertInstanceOf('StarCitizen\Models\Threads', $account->threads);
        $this->assertInstanceOf('StarCitizen\Models\Posts', $account->posts);

        $this->assertEquals('jethro_e7', Accounts::findProfile("jethro_e7")->with('posts', 'threads')->handle);
    }

    public function testBadMethod()
    {
        $this->setExpectedException('BadFunctionCallException', "methodDoesNotExist doesn't exist in this class, client not checked");
        Accounts::methodDoesNotExist();
    }


}