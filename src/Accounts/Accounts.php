<?php

namespace StarCitizen\Accounts;

use StarCitizen\Contracts\ClientAwareTrait;

/**
 * Class Accounts
 *
 * @package StarCitizen\Accounts;
 */
class Accounts
{
    use ClientAwareTrait;

    /**
     * @var string
     */
    protected static $system = "accounts";

    /**
     * @var array
     */
    protected static $allowedProfileTypes = [
        "dossier",
        "forum_profile",
        "full_profile",
        "threads",
        "posts",
        "memberships"
    ];

    /**
     *
     * @param $id
     * @param string $profile_type
     * @param bool $cache
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public static function get($id, $profile_type = "full_profile", $cache = false) {

        $profile_type = ($cache === true)? "full_profile" : $profile_type;
        $cache = ($cache === true)? "cache" : "live";

        $params = [
            'api_source' => $cache,
            'system' => self::$system,
            'action' => $profile_type,
            'target_id' => $id,
            'expedite' => '0',
            'format' => 'json'
        ];

        ;
        return self::$client->getResult($params)->getBody();
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getAll()
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