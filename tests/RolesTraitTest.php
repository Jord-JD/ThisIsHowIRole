<?php

namespace JordJD\ThisIsHowIRole\Tests;

use JordJD\ThisIsHowIRole\RolesTrait;
use JordJD\ThisIsHowIRole\Utils;
use PHPUnit\Framework\TestCase;

class RolesTraitTest extends TestCase
{
    public function testRoleManagerLoadsWithTestModeOnSupportedPhpVersions()
    {
        Utils::enableTestMode();

        $user = new UserWithRoles();

        $this->assertTrue($user->roles->has('example-role'));

        Utils::disableTestMode();
    }
}

class UserWithRoles
{
    use RolesTrait;

    public $id = 1;
}
