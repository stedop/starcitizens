<?php
namespace StarCitizen\Models;

/**
 * Class Posts
 *
 * @package StarCitizen\Models;
 * * @method bool|Post __get($name) magic method. Returns a thread if the id is set
 * @method bool|Post offsetGet($offset) Returns a thread if the id is set
 */
class Posts extends Store
{
    /**
     * Posts constructor.
     *
     * @param $postsData
     */
    public function __construct($postsData)
    {

        foreach ($postsData as $post) {
            $this->offsetSet($post['post']['post_id'], new Post($post['post']));
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Post)
            parent::offsetSet($offset, $value);
    }
}