<?php

namespace StarCitizen\Organisations;

use StarCitizen\Base\StarCitizenAbstract;
use StarCitizen\Models\Organisation;
use StarCitizen\Models\Store;

/**
 * Class Organisations
 *
 * @package StarCitizen\Orginisations;
 */
final class Organisations extends StarCitizenAbstract
{

    const ORG = 'single_organization';
    const MEMBERS = 'organization_members';
    const BASEPROFILE = Organisations::ORG;

    /**
     * Model map
     */
    const MODELS = [
        Organisations::ORG => '\Organisation',
        Organisations::MEMBERS => ['\OrgMember', '', 'handle']
    ];

    /**
     * @var string
     */
    protected static $system = "organizations";


    /**
     * @param $id
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Organisation
     */
    public static function findOrg($id, $cache = false, $raw = false)
    {
        return self::find($id, Organisations::ORG, $cache, $raw);
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
        return self::find($id, Organisations::MEMBERS, $cache, $raw);
    }
}