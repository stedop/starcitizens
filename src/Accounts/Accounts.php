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
     * @param $id
     * @param string $profile_type
     * @param bool $cache
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    private static function get($id, $profile_type = Accounts::FULL, $cache = false)
    {
        $profile_type = ($cache === true)? Accounts::FULL : $profile_type;
        $cache = ($cache === true)? "cache" : "live";

        $params = [
            'api_source' => $cache,
            'system' => self::$system,
            'action' => $profile_type,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json'
        ];

        return self::$client->getResult($params)->getBody();
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    private function getAll()
    {
        $params = [
            'api_source' => "cache",
            'system' => self::$system,
            'action' => "all_accounts",
            'format' => 'json'
        ];

        return self::$client->getResult($params)->getBody();
    }
}