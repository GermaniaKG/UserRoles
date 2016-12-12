<?php
namespace tests;

use Germania\UserRoles\PdoUserRoles;
use Prophecy\Argument;

class PdoUserRolesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider provideCtorArgs
     */
    public function testSimpleUsage( $user_id, $user_roles )
    {

        $execution_result = true;

        $stmt = $this->prophesize(\PDOStatement::class);
        $stmt->execute( Argument::type('array') )->willReturn( $execution_result );
        $stmt->fetchAll( Argument::type('int') )->willReturn( $user_roles );
        $stmt_mock = $stmt->reveal();

        $pdo = $this->prophesize(\PDO::class);
        $pdo->prepare( Argument::type('string') )->willReturn( $stmt_mock );

        $sut = new PdoUserRoles( $pdo->reveal() );
        $result = $sut( $user_id );

        $this->assertEquals( $result, $user_roles );
        $this->assertInternalType( "array", $result );
    }


    /**
     * @dataProvider provideCtorArgs
     */
    public function testFailingExecution( $user_id, $user_roles )
    {
        $execution_result = false;

        $stmt = $this->prophesize(\PDOStatement::class);
        $stmt->execute( Argument::type('array') )->willReturn( $execution_result );
        $stmt->fetchAll( Argument::type('int') )->willReturn( $user_roles );
        $stmt_mock = $stmt->reveal();

        $pdo = $this->prophesize(\PDO::class);
        $pdo->prepare( Argument::type('string') )->willReturn( $stmt_mock );

        $this->expectException( \RuntimeException::class );

        $sut = new PdoUserRoles( $pdo->reveal() );
        $result = $sut( $user_id );
    }


    public function provideCtorArgs()
    {
        return array(
            [ 1, array(1,2) ],
            [ 1, array() ]

        );
    }

}
