<?php
namespace tests;

use Germania\UserRoles\PdoAssignUserToRole;
use Prophecy\Argument;
use Psr\Log\NullLogger;

class PdoAssignUserToRoleTest extends \PHPUnit_Framework_TestCase
{

    public $logger;

    public function setUp()
    {
        $this->logger = new NullLogger;
    }


    /**
     * @dataProvider provideCtorArgs
     */
    public function testSimpleUsage( $user_id, $role_id, $execution_result )
    {

        $stmt = $this->prophesize(\PDOStatement::class);
        $stmt->execute( Argument::type('array') )->willReturn( $execution_result );
        $stmt_mock = $stmt->reveal();

        $pdo = $this->prophesize(\PDO::class);
        $pdo->prepare( Argument::type('string') )->willReturn( $stmt_mock );

        $sut = new PdoAssignUserToRole( $pdo->reveal(), $this->logger );
        $result = $sut( $user_id, $role_id );

        $this->assertEquals( $result, $execution_result );
        $this->assertInternalType( "bool", $result );
    }




    public function provideCtorArgs()
    {
        return array(
            [ 1, 42, true ],
            [ 1, 42, false ]
        );
    }

}
