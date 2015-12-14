<?php

namespace StarCitizen\Models;
use StarCitizen\Accounts\Accounts;

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
     * @var Threads
     */
    public $threads;

    /**
     * @var Posts
     */
    public $posts;

    /**
     * Profile constructor.
     *
     * @param $profileData
     *
     * @return Profile
     */
    public function __construct($profileData)
    {
        foreach ($profileData as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @return bool|Threads|string
     */
    public function threads()
    {
        $this->threads = Accounts::findThreads($this->handle);

        return $this->threads;
    }

    /**
     * @return bool|Posts|string
     */
    public function posts()
    {
        $this->posts = Accounts::findPosts($this->handle);

        return $this->posts;
    }

    /**
     * @param array ...$types
     *
     * @return $this
     */
    public function with(...$types) {
        foreach ($types as $type) {
            if (method_exists($this, strtolower($type)))
                call_user_method($type, $this);
        }

        return $this;
    }
}