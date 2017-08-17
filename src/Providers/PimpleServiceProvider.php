<?php
namespace Germania\UserRoles\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PimpleServiceProvider implements ServiceProviderInterface
{

    /**
     * @implements ServiceProviderInterface
     */
    public function register(Container $dic)
    {


        /**
         * @return StdClass
         */
        $dic['Roles.Config'] = function( $dic ) {
            return (object) [
                'all' => [
                    'guest' =>      1,
                    'registered' => 2,
                    'superuser' =>  3,
                    'admin' =>      4
                ],

                "guests" => [ 1 ],
                "new_users" => [ 2 ]
            ];
        };


        $dic['Roles.pdo'] = function( $dic ) {
            return false;
        };


        /**
         * @return StdClass
         */
        $dic['Roles.all'] = function( $dic ) {
            return (object) $dic['Roles.Config']->all;
        };


        /**
         * @return array
         */
        $dic['Roles.guests'] = function( $dic ) {
            return $dic['Roles.Config']->guests;
        };


        /**
         * @return array
         */
        $dic['Roles.new_users'] = function( $dic ) {
            return $dic['Roles.Config']->new_users;
        };






    }
}

