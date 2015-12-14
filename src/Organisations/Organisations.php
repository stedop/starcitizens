<?php

namespace StarCitizen\Organisations;
use StarCitizen\Base\StarCitizenAbstract;
use StarCitizen\Models\Organisation;

/**
 * Class Organisations
 *
 * @package StarCitizen\Orginisations;
 */
class Organisations extends StarCitizenAbstract
{

    const ORG = 'single_organization';
    const MEMBERS = 'members';

    /**
     * Model map
     */
    const MODELS = [
        Organisations::ORG => '\Organisation',
        Organisations::MEMBERS => '\Members'
    ];

    /**
     * @var string
     */
    protected static $system = "organizations";

    /**
     * @param $id
     * @param string $action
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|mixed
     */
    protected static function find($id, $action = Organisations::ORG, $cache = false, $raw = false)
    {
        $cache = ($cache === true)? "cache" : "live";

        $params = [
            'api_source' => $cache,
            'system' => self::$system,
            'action' => $action,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json'
        ];

        $response = json_decode(self::$client->getResult($params)->getBody()->getContents(), true);
        if ($response['request_stats']['query_status'] == "success")
            if ($raw === true)
                return $response;
            else
                return self::fillModel($action, $response['data']);

        return false;
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Organisation
     */
    protected static function findOrg($id, $cache = false, $raw = false)
    {
        return static::find($id, Organisations::ORG, $cache, $raw);
    }
}