<?php
namespace Germania\UserRoles;

class PdoUserRoles
{

    /**
     * @var string
     */
    public $table = 'users_roles_mm';


    /**
     * @var PDOStatement
     */
    public $stmt;


    /**
     * @param PDO           $pdo
     * @param string        $table  Optional: Users table name
     */
    public function __construct( \PDO $pdo, $table = null  )
    {
        $this->table = $table ?: $this->table;

        // ID is listed twice here in order to use it with FETCH_UNIQUE as array key
        $sql = "SELECT
        role_id
        FROM {$this->table}
        WHERE client_id = :user_id";

        // Store for later use
        $this->stmt = $pdo->prepare( $sql );
    }


    /**
     * @param  int   $user_id User ID
     * @return array Array of Role IDs
     */
    public function __invoke( $user_id ) {
        $result = $this->stmt->execute([
            'user_id' => $user_id
        ]);

        if ($result) {
            return $this->stmt->fetchAll(\PDO::FETCH_COLUMN);
        }

        throw new \RuntimeException( "PDOStatement execution on table " . $this->table . " returned FALSE");
    }

}

