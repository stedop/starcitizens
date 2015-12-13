<?php

namespace StarCitizen\Base;

use StarCitizen\Client\StarCitizensClient;

/**
 * Class ClientAwareTrait
 *
 * @package StarCitizen\Contracts
 */
abstract class StarCitizenAbstract
{
    /**
     * @var bool|StarCitizensClient
     */
    protected static $client = false;

    const MODELS = [];
    /**
     * Setup the client, this is kind of singleton and anti-patterny but it will work nicely
     */
    protected static function setupClient()
    {
        if (static::$client === false)
            static::$client = new StarCitizensClient();
    }

    /**
     * Magic call static, allows us to check that the client is setup and then pass on the call,
     * saves us having to do this at the start of every function.  Kinda like middleware
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if (method_exists(get_called_class(), $name)) {
            static::setupClient();
            return forward_static_call_array([get_called_class(), $name], $arguments);
        }

        throw  new \BadFunctionCallException($name . " doesn't exist in this class, client not checked");
    }

    /**
     * Fills our model in with the provided data
     *
     * @param $profileType
     * @param $fillData
     *
     * @return mixed
     */
    public static function fillModel($profileType, $fillData)
    {
        $object = new \ReflectionClass('StarCitizen\Models' . static::MODELS[$profileType]);
        return $object->newInstance($fillData);
    }
}