<?php

namespace StarCitizen\Contracts;

use StarCitizen\StarCitizensClient;

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

    private static function setupClient()
    {
        if (static::$client === false)
            static::$client = new StarCitizensClient();
    }

    public static function __callStatic($name, $arguments)
    {
        if (method_exists(get_called_class(), $name)) {
            static::setupClient();
            return forward_static_call_array([get_called_class(), $name], $arguments);
        }

        throw  new \BadFunctionCallException($name . " doesn't exist in this class, client not checked");
    }


}