<?php

namespace StarCitizen\Models;

/**
 * Class Profile
 *
 * @package StarCitizen\Models
 */
class Profile
{
    /**
     * @var string
     */
    public $handle;

    /**
     * @var
     */
    public $citizen_number;

    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    public $moniker;

    /**
     * @var
     */
    public $avatar;

    /**
     * @var
     */
    public $enlisted;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $title_image;

    /**
     * @var
     */
    public $bio;

    /**
     * @var
     */
    public $website_link;

    /**
     * @var
     */
    public $website_title;

    /**
     * @var
     */
    public $country;

    /**
     * @var
     */
    public $region;

    /**
     * @var
     */
    public $fluenc;

    /**
     * @var
     */
    public $discussion_count;

    /**
     * @var
     */
    public $post_count;

    /**
     * @var
     */
    public $last_forum_visit;

    /**
     * @var
     */
    public $forum_roles;

    /**
     * @var
     */
    public $organizations;

    /**
     * @var
     */
    public $date_added;

    /**
     * @var
     */
    public $last_scrape_date;


    /**
     * Profile constructor.
     *
     * @param $profileData
     */
    public function __construct($profileData)
    {
        foreach ($profileData as $key => $value) {
            $this->$key = $value;
        }
    }
}