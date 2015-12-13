<?php

namespace StarCitizen\Models;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

/**
 * Class Threads
 *
 * @package StarCitizen\Models
 */
class Threads implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    public $threads = [];

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

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->threads);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        if (array_key_exists($offset, $this->threads))
            return true;

        return false;
    }

    /**
     * @param mixed $offset
     *
     * @return bool|Thread
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset))
            return $this->threads[$offset];

        return false;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Thread)
            $this->threads[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset) && isset($this->threads[$offset]))
            unset ($this->threads[$offset]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->threads);
    }

    /**
     * @param $name
     *
     * @return bool|Thread
     */
    function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param $name
     * @param $value
     */
    function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}