<?php

namespace StarCitizen\Accounts;

use StarCitizen\Contracts\StarCitizenAbstract;
/**
 * Class Accounts
 *
 * @package StarCitizen\Accounts;
 */
class Accounts extends StarCitizenAbstract
{

    /**
     * @var string
     */
    protected static $system = "accounts";

    /**
     * Constants Profile Types
     */
    const DOSSIER = "dossier";
    const FORUM = "forum_profile";
    const FULL = "full_profile";
    const THREADS = "threads";
    const POSTS = "posts";
    const MEMBERSHIPS = "memberships";
    /**
     * Object Map
     */
    const OBJECTS = [
        Accounts::DOSSIER => 'StarCitizen\Accounts\Profile',
        Accounts::FORUM => 'StarCitizen\Accounts\Profile',
        Accounts::FULL => 'StarCitizen\Accounts\Profile',
        Accounts::THREADS => "Thread",
        Accounts::POSTS => "",
        Accounts::MEMBERSHIPS => "",
    ];

    /**
     * @param $id
     * @param string $profileType
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|mixed
     */
    protected static function find($id, $profileType = Accounts::FULL, $cache = false, $raw = false)
    {
        $profileType = ($cache === true)? Accounts::FULL : $profileType;
        $cache = ($cache === true)? "cache" : "live";

        $params = [
            'api_source' => $cache,
            'system' => self::$system,
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
                return Accounts::fillObject($profileType, $response['data']);

        return false;
    }

    /**
     * @param $profileType
     * @param $fillData
     *
     * @return mixed
     */
    protected static function fillObject($profileType, $fillData)
    {
        $object = new \ReflectionClass(Accounts::OBJECTS[$profileType]);
        return $object->newInstance($fillData);
    }
}