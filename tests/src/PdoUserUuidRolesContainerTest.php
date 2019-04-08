<?php
namespace tests;

use Germania\UserRoles\PdoUserUuidRolesContainer;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PdoUserUuidRolesContainerTest extends \PHPUnit\Framework\TestCase
{
	use MockPdoTrait;


	public function testCtor()
	{
		$stmt_mock = $this->createMockPdoStatement( true, array() );
		$pdo = $this->createMockPdo( $stmt_mock );

		$sut = new PdoUserUuidRolesContainer($pdo, "table1", "table2", "table2");
		$this->assertTrue( is_callable($sut));
		$this->assertInstanceOf( ContainerInterface::class, $sut);

		return $sut;
	}	


	public function testInvokation()
	{
		$expected_result = array( "foo ") ;
		$stmt_mock = $this->createMockPdoStatement( true, $expected_result);
		$pdo = $this->createMockPdo( $stmt_mock );

		$sut = new PdoUserUuidRolesContainer($pdo, "table1", "table2", "table2");

		$result = $sut( "foobar");
		$this->assertEquals( $result, $expected_result);

	}

	/**
	 * @dataProvider provideHasGetterResults
	 */
	public function testHasGetter( $expected_result, $return_value )
	{
		$stmt_mock = $this->createMockPdoStatement( true, $return_value);
		$pdo = $this->createMockPdo( $stmt_mock );

		$sut = new PdoUserUuidRolesContainer($pdo, "table1", "table2", "table2");

		$result = $sut->has( "foobar");
		$this->assertEquals( $result, $expected_result);

	}


	/**
	 * @dataProvider provideHasGetterResults
	 */
	public function testGetGetter( )
	{
		$stmt_mock = $this->createMockPdoStatement( true, array("foo"));
		$pdo = $this->createMockPdo( $stmt_mock );

		$sut = new PdoUserUuidRolesContainer($pdo, "table1", "table2", "table2");

		$result = $sut->get( "foobar");
		$this->assertTrue( !empty($result));

	}


	/**
	 * @dataProvider provideHasGetterResults
	 */
	public function testNotFoundExceptionGetGetter( )
	{
		$stmt_mock = $this->createMockPdoStatement( true, array());
		$pdo = $this->createMockPdo( $stmt_mock );

		$sut = new PdoUserUuidRolesContainer($pdo, "table1", "table2", "table2");

		$this->expectException( NotFoundExceptionInterface::class );
		$result = $sut->get( "foobar");
	}

	

	public function provideHasGetterResults()
	{
		return array(
			[ true, array("foo")],
			[ false, array() ],
		);
	}
}
