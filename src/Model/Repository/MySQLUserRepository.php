<?php
declare(strict_types=1);

namespace Salle\LSocial\Model\Repository;

use PDO;
use Salle\LSocial\Model\User;
use Salle\LSocial\Model\UserRepository;

final class MySQLUserRepository implements UserRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDOSingleton $database;

    public function __construct(PDOSingleton $database)
    {
        $this->database = $database;
    }

    public function save(User $user): void
    {
    }
}