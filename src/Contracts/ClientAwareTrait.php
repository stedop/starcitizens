<?php

namespace StarCitizen\Contracts;

use StarCitizen\StarCitizensClient;

trait ClientAwareTrait
{
    protected static $client = false;

    public static function setupClient()
    {
        if (self::$client === false)
            self::$client = new StarCitizensClient();
    }

    public static function __callStatic($name, $arguments)
    {
        if (function_exists($name)) {
            self::setupClient();
            call_user_func_array($name, $arguments);
        }

        throw  new \BadFunctionCallException($name . " doesn't exist in this class, client not checked");
    }


}