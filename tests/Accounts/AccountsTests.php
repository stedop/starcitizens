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
        $threads = Accounts::findThreads("Jethro_E7");
        $this->assertInstanceOf('StarCitizen\Models\Store', $threads);
        $this->assertTrue(count($threads) > 0);
        foreach ($threads as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
        }
    }

    public function testPosts()
    {
        $posts = Accounts::findPosts("Jethro_E7");
        $this->assertInstanceOf('StarCitizen\Models\Store', $posts);
        $this->assertTrue(count($posts) > 0);
        foreach ($posts as $post) {
            $this->assertInstanceOf('StarCitizen\Models\Post', $post);
        }
    }   

    public function testMagic()
    {
        $account = Accounts::findProfile("jethro_e7");
        $this->assertInstanceOf('StarCitizen\Models\Profile', $account);

        $this->assertInstanceOf('StarCitizen\Models\Store', $account->threads);

        foreach ($account->threads as $thread) {
            $this->assertInstanceOf('StarCitizen\Models\Thread', $thread);
        }

        $this->assertInstanceOf('StarCitizen\Models\Store', $account->posts);

        foreach ($account->posts as $post) {
            $this->assertInstanceOf('StarCitizen\Models\Post', $post);
        }

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Property notReal does not exist in this class');
        $account->notReal;
    }

    public function testWith()
    {
        $account = Accounts::findProfile("jethro_e7")->with('posts', 'Threads', 'doesNotExist');
        $this->assertInstanceOf('StarCitizen\Models\Store', $account->threads);
        $this->assertInstanceOf('StarCitizen\Models\Store', $account->posts);

        $this->assertEquals('jethro_e7', Accounts::findProfile("jethro_e7")->with('posts', 'threads')->handle);
    }
}