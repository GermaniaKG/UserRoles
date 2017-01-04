<?php
namespace Germania\UserRoles;

trait RolesAwareTrait
{

    /**
     * @var array
     */
    public $roles = array();


    /**
     * @param array $roles Role IDs
     * @return self Fluid Interface
     * @implements RolesAwareInterface
     */
    public function setRoles( array $roles )
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return array
     * @implements RolesAwareInterface
     */
    public function getRoles()
    {
        return $this->roles;
    }

}
