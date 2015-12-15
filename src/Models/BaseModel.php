<?php
namespace StarCitizen\Models;

/**
 * Class BaseModel
 *
 * @package StarCitizen\Models;
 */
class BaseModel
{
    /**
     * @var array
     */
    protected $magicProperties = [];

    /**
     * @param array ...$types
     *
     * @return $this
     */
    public function with(...$types) {
        foreach ($types as $type) {
            if (method_exists($this, strtolower($type)))
                call_user_func([$this, $type]);
        }

        return $this;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (in_array($name, $this->magicProperties)) {
            return call_user_func([$this, $name]);
        }

        return null;
    }
}