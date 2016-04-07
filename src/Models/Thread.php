<?php
namespace StarCitizen\Models;

/**
 * Class Thread
 *
 * @package StarCitizen\Models
 */
class Thread extends Model
{
    public $thread_title;
    public $thread_id;
    public $thread_replies;
    public $thread_views;
    public $original_poster=[];
    public $original_post = [];
    public $recent_poster = [];
    public $recent_post;

    /**
     * Thread constructor.
     *
     * @param $threadData
     */
    public function __construct($threadData)
    {
        foreach ($threadData as $key => $value) {
            $this->$key = $value;
        }
    }
}