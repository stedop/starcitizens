<?php

namespace StarCitizen\Accounts;

use StarCitizen\Base\AbstractEntity;
use StarCitizen\Models\Profile;
use StarCitizen\Models\Store;

/**
 * Class Accounts
 *
 * @package StarCitizen\Accounts;
 */
class Accounts extends AbstractEntity
{

    /**
     * @var string
     */
    protected static $system = "accounts";

    /**
     * Constants Profile Types
     */
    const FULL = "full_profile";
    const THREADS = "threads";
    const POSTS = "posts";

    /**
     * Model Map
     */
    const MODELS = [
        Accounts::FULL => '\Profile',
        Accounts::THREADS => ['\Thread', '', 'thread_id'],
        Accounts::POSTS => ['\Post', 'post', 'post_id']
    ];

    const BASEPROFILE = Accounts::FULL;

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Profile|string
     */
    public static function findProfile($id, $cache = false, $raw = false)
    {
        return self::find($id, Accounts::FULL, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Store|string
     */
    public static function findThreads($id, $cache = false, $raw = false)
    {
        return self::find($id, Accounts::THREADS, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Store|string
     */
    public static function findPosts($id, $cache = false, $raw = false)
    {
        return self::find($id, Accounts::POSTS, $cache, $raw);
    }
}