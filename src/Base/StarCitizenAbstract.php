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

    protected static $system;

    const MODELS = [];
    const BASEPROFILE = '';

    /**
     * Find an account information
     *
     * @param $id
     * @param string $profileType
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|mixed
     */
    protected static function find($id, $profileType, $cache = false, $raw = false)
    {
        self::setupClient();
        $cache = ($cache === true)? "cache" : "live";

        $params = [
            'api_source' => $cache,
            'system' => static::$system,
            'action' => $profileType,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json'
        ];

        $response = json_decode(self::$client->getResult($params)->getBody()->getContents(), true);
        if ($response['request_stats']['query_status'] == "success")
            if ($raw === true)
                return $response;
            else
                return self::fillModel($profileType, $response['data']);

        return false;
    }

    /**
     * Setup the client, this is kind of singleton and anti-patterny but it will work nicely
     */
    private static function setupClient()
    {
        if (static::$client === false)
            static::$client = new StarCitizensClient();
    }

    /**
     * Fills our model in with the provided data
     *
     * @param $modelType
     * @param $fillData
     *
     * @return mixed
     */
    public static function fillModel($modelType, $fillData)
    {
        $object = new \ReflectionClass('StarCitizen\Models' . static::MODELS[$modelType]);
        return $object->newInstance($fillData);
    }
}