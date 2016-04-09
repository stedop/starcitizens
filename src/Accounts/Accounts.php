<?php

namespace StarCitizen\Accounts;

use StarCitizen\Models\Profile;
use StarCitizen\Models\Store;
use StarCitizen\StarCitizens;

/**
 * Class Accounts
 *
 * @package StarCitizen\Accounts;
 */
class Accounts
{
    /**
     * Constants Profile Types
     */
    const FULL = "full_profile";
    const THREADS = "threads";
    const POSTS = "posts";
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
        $starCitizens = new StarCitizens();
        return $starCitizens->accounts($id, self::BASEPROFILE, $cache, $raw);
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
        $starCitizens = new StarCitizens();
        return $starCitizens->accounts($id, Accounts::THREADS, $cache, $raw);
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
        $starCitizens = new StarCitizens();
        return $starCitizens->accounts($id, Accounts::POSTS, $cache, $raw);
    }
}