<?php
namespace tests;

use Germania\UserRoles\Providers\PimpleServiceProvider;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class PimpleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisteringServiceProvider()
    {
        $dic = new Container;

        $sut = new PimpleServiceProvider;
        $sut->register( $dic );

        $this->assertInstanceOf(ServiceProviderInterface::class, $sut);

        $this->assertInternalType('object', $dic['Roles.Config']);
        $this->assertInternalType('object', $dic['Roles.all']);
        $this->assertInternalType('array', $dic['Roles.guests']);
        $this->assertInternalType('array', $dic['Roles.new_users']);

        $this->assertFalse($dic['Roles.pdo']);

    }
}
