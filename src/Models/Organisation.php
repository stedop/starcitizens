<?php
namespace StarCitizen\Models;
use StarCitizen\Organisations\Organisations;

/**
 * Class Organization
 *
 * @package StarCitizen\Models;
 */
class Organisation extends Model
{
    /**
     * Org vars
     */
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

    /**
     * @var array
     */
    protected $magicProperties = [
        'members'
    ];

    private $members;

    /**
     * Organisation constructor.
     *
     * @param $orgData
     */
    public function __construct($orgData)
    {
        foreach ($orgData as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return null|Store
     */
    protected function members()
    {
        if ($this->members === null) {
            $members = Organisations::findMembers($this->sid);
            if ($members instanceof Store)
                $this->members = $members;
        }

        return $this->members;
    }
}