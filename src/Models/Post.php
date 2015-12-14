<?php
namespace StarCitizen\Models;

/**
 * Class Post
 *
 * @package StarCitizen\Models;
 */
class Post
{
    public  $post_time;
    public  $last_edit_time;
    public  $post_text;
    public  $signature;
    public  $post_id;
    public  $thread_id;
    public  $thread_title;
    public  $permalink;

    public function __construct($postdData)
    {
        foreach ($postdData as $key => $value) {
            $this->$key = $value;
        }
    }
}