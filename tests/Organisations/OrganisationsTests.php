<?php

namespace StarCitizen\Tests\Organisations;

use StarCitizen\Organisations\Organisations;

/**
 * Class OrganisationsTests
 *
 * @package Organisations;
 */
class OrganisationsTests extends \PHPUnit_Framework_TestCase
{
    public function testOrgs()
    {
        $this->assertFalse(Organisations::findOrg('notRealOrg'));
        $this->assertInstanceOf('StarCitizen\Models\Organisation', Organisations::findOrg('salvage'));
    }

    public function testMembers()
    {
        $this->assertFalse(Organisations::findMembers('notRealOrg'));
        $members = Organisations::findMembers('salvage');
        $this->assertInstanceOf('StarCitizen\Models\Store', $members);
        $this->assertTrue(count($members) > 0);

        foreach ($members as $member) {
            $this->assertInstanceOf('StarCitizen\Models\OrgMember', $member);
        }
    }

    public function testMagic()
    {
        $org = Organisations::findOrg('salvage');

        $members = $org->members;
        $this->assertInstanceOf('StarCitizen\Models\Store', $members);
        $this->assertTrue(count($members) > 0);

        foreach ($members as $member) {
            $this->assertInstanceOf('StarCitizen\Models\OrgMember', $member);
            $profile = $member->profile;
            $this->assertInstanceOf('StarCitizen\Models\Profile', $profile);
        }
    }

    public function testWith()
    {
        $org = Organisations::findOrg('salvage')->with('members');
        $this->assertInstanceOf('StarCitizen\Models\Store', $org->members);
    }
}