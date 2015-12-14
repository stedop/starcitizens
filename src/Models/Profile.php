<?php

namespace StarCitizen\Models;

use StarCitizen\Accounts\Accounts;

/**
 * Class Profile
 *
 * @package StarCitizen\Models
 *
 * @property Threads $threads
 * @property Posts$posts
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
     * @var array
     */
    private $magicProperties = [
        'threads',
        'posts'
    ];

    /**
     * @var Threads
     */
    private $threads;

    /**
     * @var Posts
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
     * @return Threads
     */
    protected function threads()
    {
        if ($this->threads === null) {
            $threads = Accounts::findThreads($this->handle);
            if ($threads instanceof Threads)
                $this->threads = $threads;
        }



        return $this->threads;
    }

    /**
     * @return Posts
     */
    protected function posts()
    {
        if ($this->posts === null) {
            $posts = Accounts::findPosts($this->handle);
            if ($posts instanceof Posts)
                $this->posts = $posts;
        }

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
                call_user_func([$this, $type]);
        }

        return $this;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (in_array($name, $this->magicProperties)) {
            return call_user_func([$this, $name]);
        }

        return null;
    }
}