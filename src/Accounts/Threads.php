<?php
namespace StarCitizen\Accounts;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;
use ArrayIterator;

/**
 * Class Threads
 *
 * @package StarCitizen\Accounts;
 */
class Threads implements ArrayAccess, Countable, IteratorAggregate, Traversable
{
    /**
     * @var array
     */
    public $threads = [];

    public function __construct($threadsData)
    {
        foreach ($threadsData as $thread) {
            $this->offsetSet($thread['thread_id'], new Thread($thread));
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->threads);
    }

    public function offsetExists($offset)
    {
        if (array_key_exists($offset, $this->threads))
            return true;

        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset))
            return $this->threads[$offset];

        return false;
    }

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Thread)
            $this->threads[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset) && isset($this->threads[$offset]))
            unset ($this->threads[$offset]);
    }

    public function count()
    {
        return count($this->threads);
    }

    function __get($name)
    {
        return $this->offsetGet($name);
    }

    function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}