<?php

namespace StarCitizen\Models;

/**
 * Class Threads
 *
 * @package StarCitizen\Models
 * @method bool|Thread __get($name) magic method. Returns a thread if the id is set
 * @method bool|Thread offsetGet($offset) Returns a thread if the id is set
 */
class Threads extends Store
{
    /**
     * Threads constructor.
     *
     * @param $threadsData
     */
    public function __construct($threadsData)
    {
        foreach ($threadsData as $thread) {
            $this->offsetSet($thread['thread_id'], new Thread($thread));
        }
    }

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Thread)
            parent::offsetSet($offset, $value);
    }
}