<?php
namespace tests;

use Germania\UserRoles\RolesAwareTrait;

class RolesAwareTraitTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideRoles
     */
    public function testSimpleUsage( $roles)
    {

        $mock = $this->getMockForTrait( RolesAwareTrait::class );

        $same = $mock->setRoles($roles)->getRoles();
        $this->assertInternalType("array", $same);
        $this->assertSame($same, $roles);
    }


    public function provideRoles()
    {
        return array(
            [ array(1, 2) ],
            [ array("foo", "bar") ]
        );
    }
}
