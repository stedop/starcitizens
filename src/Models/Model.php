<?php
namespace StarCitizen\Models;

/**
 * Class BaseModel
 *
 * @package StarCitizen\Models;
 */
abstract class Model
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
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (in_array($name, $this->magicProperties)) {
            return call_user_func([$this, $name]);
        }

        throw new \Exception('Property ' . $name . ' does not exist in this class');
    }


    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }
}