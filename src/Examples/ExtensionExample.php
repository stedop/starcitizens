<?php

namespace StarCitizen\Examples;

use StarCitizen\Models\Profile;

/**
 * Class ExtensionExample
 *
 * Extends the profile and adds a check to see if the user has a link to their reddit account in
 * their bio.
 *
 * This could be used to show that the owner of this account is also on reddit.
 *
 * @package StarCitizen\Examples
 */
class ExtensionExample extends Profile
{
    /**
     * Matches the username
     *
     * @param $redditUsername
     *
     * @return bool
     */
    public function isRedditor($redditUsername)
    {
        if (preg_match("%^((https?://)|reddit.com/u(ser)?/" . $redditUsername . "/?\s*(<br />)?\\n%i",$this->bio) == 1) {
            return true;
        }

        return false;
    }
}