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
}