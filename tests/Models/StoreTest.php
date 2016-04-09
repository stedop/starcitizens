<?php
namespace StarCitizen\Tests\Models;

use StarCitizen\Accounts\Accounts;
use StarCitizen\Models\Store;

/**
 * Class StoreTest
 *
 * @package Models;
 */
class StoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Store
     */
    public $posts;

    /**
     * @var array
     */
    public $post_ids = [];

    public function setUp()
    {
        $this->posts = Accounts::findPosts("Jethro_E7");
        foreach ($this->posts as $post) {
            $this->post_ids[] = $post->post_id;
        }
    }

    public function testInstantiate()
    {
        $rawData = Accounts::findPosts("Jethro_E7", true, false);
        $store = new Store($rawData['data'], '\Post', 'post', 'post_id');

        $store->new = true;
        $this->assertFalse($store->new);
    }

    public function testOffsetExists()
    {
        // Testing offset exists
        $this->assertTrue($this->posts->offsetExists($this->post_ids[0]));
    }

    public function testGet()
    {
        // Testing offset get
        $post = $this->posts->offsetGet($this->post_ids[0]);
        $this->assertInstanceOf('StarCitizen\Models\Post', $post);

        // Testing magic get
        $post_id = $this->post_ids[0];
        $post = $this->posts->$post_id;
        $this->assertInstanceOf('StarCitizen\Models\Post', $post);
    }

    public function testSet()
    {
        // Testing magic set
        $countBeforeAdd = $this->posts->count();
        $post_id = $this->post_ids[0];
        $newThread = clone $this->posts->$post_id;
        $newId = '999';
        $newThread->thread_id = $newId;
        $this->posts->$newId = $newThread;
        $this->assertTrue($this->posts->offsetExists('999'));

        $this->posts->offsetSet(null, $newThread);

        $this->assertFalse($this->posts->offsetExists(6047553));

        // Test count
        $this->assertTrue($countBeforeAdd+2 == count($this->posts));
    }

    public function testIterator()
    {
        // Test Iterator
        $iterator = $this->posts->getIterator();
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }

    public function testUnset()
    {
        // Test unset
        $this->posts->offsetUnset('999');
        $this->assertFalse($this->posts->offsetExists('999'));
    }

    public function testToString()
    {
        $this->assertJson((string) $this->posts);
    }
}