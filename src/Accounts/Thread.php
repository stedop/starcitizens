<?php
namespace StarCitizen\Accounts;

/**
 * Class Thread
 *
 * @package StarCitizen\Accounts;
 */
class Thread
{
    public $thread_title;
    public $thread_id;
    public $thread_replies;
    public $thread_views;
    public $original_poster=[];
    public $original_post = [];
    public $recent_poster = [];
    public $recent_post;

    public function __construct($threadData)
    {
        foreach ($threadData as $key => $value) {
            $this->$key = $value;
        }
    }
}