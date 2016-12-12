<?php
namespace Germania\UserRoles;

interface RolesAwareInterface
{

    /**
     * @param array $roles Roles ID array
     */
    public function setRoles( array $roles );

    /**
     * @return array Roles ID array
     */
    public function getRoles();

}
