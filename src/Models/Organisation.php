<?php
namespace StarCitizen\Models;

/**
 * Class Organization
 *
 * @package StarCitizen\Models;
 */
class Organisation
{
    public $sid;
    public $title;
    public $logo;
    public $member_count;
    public $recruiting;
    public $archetype;
    public $commitment;
    public $roleplay;
    public $lang;
    public $primary_focus;
    public $primary_image;
    public $secondary_focus;
    public $secondary_image;
    public $banner;
    public $headline;
    public $history;
    public $manifesto;
    public $charter;
    public $cover_image;
    public $cover_video;
    public $date_added;
    public $last_scrape_date;

    public function __construct($orgData)
    {
        foreach ($orgData as $key => $value) {
            $this->$key = $value;
        }
    }
}