<?php

namespace StarCitizen\Models;

use StarCitizen\Accounts\Accounts;

/**
 * Class Profile
 *
 * @package StarCitizen\Models
 *
 * @property Store $threads
 * @property Store $posts
 */
class Profile extends Model
{
    /**
     * Profile vars
     */
    public $handle;
    public $citizen_number;
    public $status;
    public $moniker;
    public $avatar;
    public $enlisted;
    public $title;
    public $title_image;
    public $bio;
    public $website_link;
    public $website_title;
    public $country;
    public $region;
    public $fluenc;
    public $discussion_count;
    public $post_count;
    public $last_forum_visit;
    public $forum_roles;
    public $organizations;
    public $date_added;
    public $last_scrape_date;

    /**
     * @var array
     */
    protected $magicProperties = [
        'threads',
        'posts'
    ];

    /**
     * @var Store
     */
    private $threads;

    /**
     * @var Store
     */
    private $posts;

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

    /**
     * @return Store
     */
    final protected function threads()
    {
        if ($this->threads === null) {
            $threads = Accounts::findThreads($this->handle);
            if ($threads instanceof Store)
                $this->threads = $threads;
        }

        return $this->threads;
    }

    /**
     * @return Store
     */
    final protected function posts()
    {
        if ($this->posts === null) {
            $posts = Accounts::findPosts($this->handle);
            if ($posts instanceof Store)
                $this->posts = $posts;
        }

        return $this->posts;
    }
}