<?php

namespace StarCitizen\Organisations;

use StarCitizen\StarCitizens;
use StarCitizen\Models\Organisation;
use StarCitizen\Models\Store;

/**
 * Class Organisations
 *
 * @package StarCitizen\Orginisations;
 */
final class Organisations
{
    const ORG = 'single_organization';
    const MEMBERS = 'organization_members';
    const BASEPROFILE = Organisations::ORG;

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Organisation
     */
    public static function findOrg($id, $cache = false, $raw = false)
    {
        $starCitizens = new StarCitizens();
        return $starCitizens->organizations($id, Organisations::ORG, $cache, $raw);
    }

    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Store
     */
    public static function findMembers($id, $cache = false, $raw = false)
    {
        $starCitizens = new StarCitizens();
        return $starCitizens->organizations($id, Organisations::MEMBERS, $cache, $raw);
    }
}