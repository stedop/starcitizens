<?php
namespace StarCitizen\Models;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

/**
 * Class Store
 *
 * @package StarCitizen\Models;
 */
class Store implements ArrayAccess, Countable, IteratorAggregate
{
    protected $items = [];

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        if (array_key_exists($offset, $this->items))
            return true;

        return false;
    }

    /**
     * @param mixed $offset
     *
     * @return bool|mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset))
            return $this->items[$offset];

        return false;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset) && isset($this->items[$offset]))
            unset ($this->items[$offset]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}