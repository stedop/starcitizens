<?php

namespace StarCitizen;

use StarCitizen\Models\Model;
use StarCitizen\Client\StarCitizensClient;

/**
 * Class StarCitizens
 * @package StarCitizen
 *
 * @method accounts($id, $profileType = false, $cache = false, $raw = false) Get accounts system results
 * @method organisations($id, $profileType = false, $cache = false, $raw = false) Get org system results
 */
final class StarCitizens
{
    /**
     * @var bool|StarCitizensClient
     */
    private static $client = false;

    private $systems = [
        "accounts" => [
            "base_action" => "full_profile",
            "actions" => [
                "full_profile" => '\Profile',
                "threads" => ['\Thread', '', 'thread_id'],
                "posts" => ['\Post', 'post', 'post_id'],
            ]
        ]
    ];

    /**
     * StarCitizens constructor.
     */
    public function __construct()
    {
        self::setupClient();
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->systems)) {
            return $this->doCall($name, $arguments);
        }

        throw new \Exception("Method {$name} not found");
    }

    /**
     * @param $name
     * @param array $arguments
     * @return bool|mixed
     */
    private function doCall($name, array $arguments = [])
    {
        $argumentCount = count($arguments);

        if ($argumentCount > 0 && $argumentCount< 2)
            return $this->callBase($arguments[0], $name);

        if ($argumentCount == 2) {
            list($id, $action) = $arguments;
            return $this->callAction($id, $name, $action);
        }

        if ($argumentCount == 4) {
            list($id, $action, $cache, $raw) = $arguments;
            return $this->find($id, $name, $action, $cache, $raw);
        }

        throw new \InvalidArgumentException("Invalid arguments");
    }

    /**
     * @param $id
     * @param $system
     * @return bool|mixed
     */
    private function callBase($id, $system)
    {
        return $this->find($id, $system, $this->systems[$system]['base_action']);
    }

    /**
     * @param $id
     * @param $system
     * @param bool $action
     * @return bool|mixed
     */
    private function callAction($id, $system, $action = false)
    {
        if ($action === false)
            $action = $this->systems[$system]['base_action'];
        return $this->find($id, $system, $action);
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $starCitizens = new StarCitizens();
        return $starCitizens->__call($name, $arguments);
    }


    /**
     * Find an entity
     *
     * @param $id
     * @param $system
     * @param $profileType
     * @param bool $cache
     * @param bool $raw
     * @return bool|mixed
     */
    private function find($id, $system, $profileType, $cache = false, $raw = false)
    {
        $response = json_decode(
            self::$client
                ->getResult(
                    $this->getParams($id, $system, $profileType, $cache)
                )
                ->getBody()
                ->getContents(),
            true
        );

        return $this->checkResponse($response, $this->systems[$system]['actions'][$profileType], $raw);
    }

    /**
     * @param $id
     * @param $system
     * @param $profileType
     * @param $cache
     * @return array
     */
    private function getParams($id, $system, $profileType, $cache)
    {
        $cache = ($cache === true) ? "cache" : "live";

        return [
            'api_source' => $cache,
            'system' => $system,
            'action' => $profileType,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json',
            'start_page' => '1',
            'end_page' => '5'
        ];
    }

    /**
     * @param $response
     * @param $profileType
     * @param $raw
     *
     * @return bool|mixed
     */
    private function checkResponse($response, $profileType, $raw)
    {
        if ($response['request_stats']['query_status'] == "success") {
            if ($raw === true) {
                return $response;
            } else {
                return $this->fillModel($profileType, $response['data']);
            }
        }

        return false;
    }

    /**
     * Setup the client
     */
    private static function setupClient()
    {
        if (self::$client === false) {
            self::$client = new StarCitizensClient();
        }
    }

    /**
     * Fills our model in with the provided data
     *
     * @param $model
     * @param $fillData
     *
     * @return Model
     */
    private function fillModel($model, $fillData)
    {
        if (is_array($model)) {
            list($className, $dataRoot, $idName) =$model;
            $object = new \ReflectionClass('StarCitizen\Models\Store');
            return $object->newInstance($fillData, $className, $dataRoot, $idName);
        } else {
            $object = new \ReflectionClass('StarCitizen\Models' . $model);
            return $object->newInstance($fillData);
        }
    }
}