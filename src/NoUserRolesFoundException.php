<?php
namespace Germania\UserRoles;

use Psr\Container\NotFoundExceptionInterface;

class NoUserRolesFoundException extends \Exception implements NotFoundExceptionInterface
{}