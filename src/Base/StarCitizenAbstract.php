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

        $response = json_decode(
            self::$client
                ->getResult(
                    self::getParams($id, $profileType, $cache)
                )
                ->getBody()
                ->getContents(),
            true
        );

        return self::checkResponse($response, $profileType, $raw);
    }

    /**
     * @param $id
     * @param $profileType
     * @param $cache
     *
     * @return array
     */
    private static function getParams($id, $profileType, $cache)
    {
        $cache = ($cache === true)? "cache" : "live";

        return [
            'api_source' => $cache,
            'system' => static::$system,
            'action' => $profileType,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json'
        ];
    }

    /**
     * @param $response
     * @param $profileType
     * @param $raw
     *
     * @return bool|mixed
     */
    private static function checkResponse($response, $profileType, $raw)
    {
        if ($response['request_stats']['query_status'] == "success")
            if ($raw === true)
                return $response;
            else
                return self::fillModel($profileType, $response['data']);

        return false;
    }

    /**
     * Setup the client
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
        if (is_array(static::MODELS[$modelType])) {
            list($className, $dataRoot, $idName) = static::MODELS[$modelType];
            $object = new \ReflectionClass('StarCitizen\Models\Store');
            return $object->newInstance($fillData, $className, $dataRoot, $idName);
        } else {
            $object = new \ReflectionClass('StarCitizen\Models' . static::MODELS[$modelType]);
            return $object->newInstance($fillData);
        }
    }
}