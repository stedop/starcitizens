<?php

namespace StarCitizen;

use StarCitizen\Models\Model;
use StarCitizen\Client\StarCitizensClient;

/**
 * Class StarCitizens
 * @package StarCitizen
 *
 * @method accounts($id, $profileType = false, $cache = false, $raw = false) Get accounts system results
 * @method organizations($id, $profileType = false, $cache = false, $raw = false) Get org system results
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
        ],
        "organizations" => [
            "base_action" => "single_organization",
            "actions" => [
                "single_organization" => '\Organisation',
                "organization_members" => ['\OrgMember', '', 'handle']
            ]
        ],
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
     * @param $system
     * @param array $arguments
     * @return bool|mixed
     */
    private function doCall($system, array $arguments = [])
    {
        $id = '';
        $cache = false;
        $raw = false;
        $action = "";

        $fixedArguments = $this->standardFindArguments($arguments);
        extract($fixedArguments, EXTR_OVERWRITE);
        $action = ($action == "") ? $this->systems[$system]['base_action'] : $action;
        return $this->find($id, $system, $action, $raw, $cache);
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function standardFindArguments(array $arguments)
    {

        $defaults = [
            'id' => '',
            'action' => '',
            'raw' => false,
            'cache' => false,
        ];

        $varNames = array_keys($defaults);

        for ($argumentCount = 0; $argumentCount < 4; $argumentCount++) {
            if (array_key_exists($argumentCount, $arguments)) {
                $defaults[$varNames[$argumentCount]] = $arguments[$argumentCount];
            }
        }
        
        return $defaults;
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
     * @param bool $raw
     * @param bool $cache
     * @return bool|mixed
     */
    private function find($id, $system, $profileType, $raw = false, $cache = false)
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