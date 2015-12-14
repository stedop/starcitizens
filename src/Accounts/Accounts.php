<?php

namespace StarCitizen\Accounts;

use StarCitizen\Base\StarCitizenAbstract;
use StarCitizen\Models\Posts;
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
    const FULL = "full_profile";
    const THREADS = "threads";
    const POSTS = "posts";

    /**
     * Model Map
     */
    const MODELS = [
        Accounts::FULL => '\Profile',
        Accounts::THREADS => '\Threads',
        Accounts::POSTS => '\Posts',
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
        return parent::find($id, Accounts::FULL, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Threads|string
     */
    public static function findThreads($id, $cache = false, $raw = false)
    {
        return parent::find($id, Accounts::THREADS, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Posts|string
     */
    public static function findPosts($id, $cache = false, $raw = false)
    {
        return parent::find($id, Accounts::POSTS, $cache, $raw);
    }
}