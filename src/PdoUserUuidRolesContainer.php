<?php
namespace Germania\UserRoles;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;


/**
 * This PSR Container gets the user role names for a given user.
 */
class PdoUserUuidRolesContainer implements ContainerInterface
{

	/**
	 * @var \PDOStatement
	 */
	public $stmt;


	/**
	 * @param \PDO   $pdo               PDO handler
	 * @param string $users_table       Table name for users
	 * @param string $users_roles_table Table name for users-roles mapping
	 */
	public function __construct( \PDO $pdo, string $users_table, string $users_roles_table, string $roles_table )
	{
		$sql = "SELECT
        R.usergroup_short_name,

        LOWER(HEX(U.uuid)) as uuid
        FROM `{$users_table}` U

        LEFT JOIN `{$users_roles_table}` UR
        ON U.id = UR.client_id

        LEFT JOIN `{$roles_table}` R
        ON UR.role_id = R.id

        HAVING uuid=:uuid";

        $this->stmt = $pdo->prepare( $sql );
	}


	/**
	 * Returns the user role names for a given user UUID.
	 *
	 * @param  string $user_id User ID or UUID
	 * @return array          
	 */
	public function __invoke( string $user_id )
	{
		$this->stmt->execute([
			'uuid' => str_replace("-", "", $user_id)
		]);

		return $this->stmt->fetchAll( \PDO::FETCH_COLUMN );
	}



	/**
	 * Alias for `get( $user_id )`, but throws NoUserRolesFoundException
	 * when no roles can be found.
	 * 
	 * @inheritDoc
	 * @throws NoUserGroupsFoundException
	 */
	public function get( $user_id )
	{	
		$user_id_str = "" . $user_id;
		$groups = $this->__invoke( $user_id_str );

		if (empty($groups)):
			throw new NoUserRolesFoundException;
		endif;

		return $groups;
	}


	/**
	 * @inheritDoc
	 */
	public function has( $user_id )
	{
		$user_id_str = "" . $user_id;
		$groups = $this->__invoke( $user_id_str );
		return !empty( $groups );
	}
}

