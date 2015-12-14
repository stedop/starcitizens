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
    const BASEPROFILE = Organisations::ORG;

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
     * @param bool $cache
     * @param bool $raw
     *
     * @return bool|Organisation
     */
    public static function findOrg($id, $cache = false, $raw = false)
    {
        return self::find($id, Organisations::ORG, $cache, $raw);
    }
}