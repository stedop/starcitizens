<?php

namespace StarCitizen\Accounts;

use StarCitizen\Base\StarCitizenAbstract;
use StarCitizen\Models\Profile;
use StarCitizen\Models\Threads;

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
     * Model Map
     */
    const MODELS = [
        Accounts::DOSSIER => '\Profile',
        Accounts::FORUM => '\Profile',
        Accounts::FULL => '\Profile',
        Accounts::THREADS => '\Threads',
        Accounts::POSTS => "",
        Accounts::MEMBERSHIPS => "",
    ];

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
                return Accounts::fillModel($profileType, $response['data']);

        return false;
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Profile|string
     */
    protected static function findProfile($id, $cache = false, $raw = false)
    {
        return self::find($id, Accounts::FULL, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Threads|string
     */
    protected static function findThreads($id, $cache = false, $raw = false)
    {
        return Accounts::find($id, Accounts::THREADS, $cache, $raw);
    }
}