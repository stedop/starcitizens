<?php
namespace StarCitizen\Models;
use StarCitizen\Accounts\Accounts;

/**
 * Class OrgMember
 *
 * @package StarCitizen\Models;
 *
 * @property Profile $profile
 */
class OrgMember
{
    /**
     * Member vars
     */
    public $sid;
    public $handle;
    public $rank;
    public $stars;
    public $roles;
    public $type;
    public $visibility;

    /**
     * @var array
     */
    protected $magicProperties = [
        'profile'
    ];

    /**
     * @var Profile
     */
    private $profile;


    /**
     * OrgMember constructor.
     *
     * @param array $memberData
     */
    public function __construct(array $memberData)
    {
        foreach ($memberData as $key => $value) {
            $this->$$key = $value;
        }
    }

    /**
     * @return Profile
     */
    final protected function profile()
    {
        if ($this->profile === null) {
            $profile = Accounts::findProfile($this->handle);
            if ($profile instanceof Profile)
                $this->$profile = $profile;
        }

        return $this->profile;
    }
}