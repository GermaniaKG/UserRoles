<?php
namespace Germania\UserRoles;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * This Callable assigns a User ID to a Role ID.
 *
 * Example:
 *
 *     <?php
 *     use Germania\UserRoles\PdoAssignUserToRole;
 *
 *     $pdo    = new PDO( ... );
 *     $logger = new Monolog();
 *     $table  = 'users_roles_mm';
 *
 *     $assigner = new PdoAssignUserToRole( $pdo, $logger, $table);
 *     $assigner( 42, 1);
 *     ?>
 *
 * @author  Carsten Witt <carstenwitt@germania-kg.de>
 */
class PdoAssignUserToRole
{

    /**
     * Database table
     * @var string
     */
    public $table = "users_roles_mm";

    /**
     * @var PDOStatement
     */
    public $stmt;

    /**
     * @var LoggerInterface
     */
    public $logger;


    /**
     * @param PDO             $pdo         PDO instance
     * @param LoggerInterface $logger      Optional: PSR-3 Logger
     * @param string          $table       Optional: Database table name
     */
    public function __construct(\PDO $pdo, LoggerInterface $logger = null, $table = null)
    {
        // Setup
        $this->table  = $table ?: $this->table;
        $this->logger = $logger ?: new NullLogger;

        // Prepare business
        $sql = "INSERT INTO {$this->table}
        (client_id, role_id)
        VALUES (:client_id, :role_id)";

        $this->stmt = $pdo->prepare( $sql );
    }


    /**
     * @param  int  $user_id
     * @param  int  $role_id
     *
     * @return bool
     */
    public function __invoke( $user_id, $role_id )
    {

        $result = $this->stmt->execute([
            'client_id' => $user_id,
            'role_id'   => $role_id
        ]);

        // Evaluate
        $loginfo = [
            'user_id'   => $user_id,
            'role_id'   => $role_id,
            'result'    => $result
        ];

        if ($result):
            $this->logger->info("Successfully assigned user to role.", $loginfo);
        else:
            $this->logger->warning("Could not assign user to role?!", $loginfo);
        endif;

        return $result;
    }
}
