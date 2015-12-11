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

    public static function get($id = false) {
        return "get called";
        if($id === false) {

        } else {

        }
    }
}