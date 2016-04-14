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
     * @var bool|StarCitizensClient The client object
     */
    private static $client = false;

    /**
     * @var array  The config for the StarCitizens todo move this to a separate file
     */
    private $systems = [];

    /**
     * @var string
     */
    public $configFile;

    /**
     * StarCitizens constructor.
     *
     * @param string $configFile
     */
    public function __construct($configFile = "Resources/config/typesConfig.php")
    {
        $this->configFile = $configFile;
        self::setupClient();
        $this->readConfig();
    }

    /**
     * Reads the basic config.
     */
    private function readConfig()
    {
        $this->systems = include $this->configFile;
    }

    /**
     * Find an entity based on id and return the correct model or raw json output
     *
     * @param $id
     * @param $system
     * @param $profileType
     * @param bool $raw
     * @param bool $cache
     * @return bool|mixed
     */
    private function get($id, $system, $profileType, $raw = false, $cache = false)
    {
        $response = json_decode(
            self::$client
                ->getResult(
                    $this->getCallParams($id, $system, $profileType, $cache)
                )
                ->getBody()
                ->getContents(),
            true
        );

        return $this->checkResponse($response, $this->systems[$system]['actions'][$profileType], $raw);
    }

    /**
     * Returns the params needed for an API call
     *
     * @param $id
     * @param $system
     * @param $profileType
     * @param $cache
     * @return array
     */
    private function getCallParams($id, $system, $profileType, $cache)
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
     * Checks the response for success messages and returns the raw response or model
     *
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
     * Fills our model in with the provided data or sends the data to a store
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

    /**
     * Magic call function based on the config information
     *
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
     * This is the real call function
     *
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

        $fixedArguments = $this->standardGetArguments($arguments);
        extract($fixedArguments, EXTR_OVERWRITE);
        $action = ($action == "") ? $this->systems[$system]['base_action'] : $action;
        return $this->get($id, $system, $action, $raw, $cache);
    }

    /**
     * Get the standard arguments for a find call and checks that we
     * have the correct arguments passed to the magic function
     *
     * @param array $arguments
     * @return array
     */
    private function standardGetArguments(array $arguments)
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
     * Allows our functions to be called statically, this is a bit hacky tbh.
     *
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
}