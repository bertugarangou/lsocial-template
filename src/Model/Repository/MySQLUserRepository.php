<?php
declare(strict_types=1);

namespace Salle\LSocial\Model\Repository;

use Exception;
use PDO;
use Salle\LSocial\Model\User;
use Salle\LSocial\Model\UserRepository;

final class MySQLUserRepository implements UserRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDOSingleton $database;
    private string $exceptionMsg = "BBDD unreachable.";

    public function __construct(PDOSingleton $database)
    {
        $this->database = $database;
    }

    public function save(User $user): void{
        if(!empty($user->getBirthday())) {
            $query = <<<'QUERY'
            INSERT INTO users(email, password, createdAt, updatedAt, birthday)
            VALUES(:email, :password, :created_at, :updated_at, :birthday)
            QUERY;
        }else{
            $query = <<<'QUERY'
            INSERT INTO users(email, password, createdAt, updatedAt)
            VALUES(:email, :password, :created_at, :updated_at)
            QUERY;
        }
        $statement = $this->database->connection()->prepare($query);

        $email = $user->getEmail();
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $password = $user->getPassword();
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $date = date('Y-m-d H:i:s');
        $statement->bindParam('created_at', $date, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $date, PDO::PARAM_STR);

        if(!empty($user->getBirthday())) {
            $birthday = $user->getBirthday();
            $statement->bindParam('birthday', $birthday, PDO::PARAM_STR);
        }

        $statement->execute();
    }

    public function checkEmailExists(string $email): bool{
        $stat = $this->database->connection()->prepare('SELECT email FROM users WHERE email=?');
        $stat->bindParam(1, $email, PDO::PARAM_STR);
        $stat->execute();
        $res = $stat->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) == 0) {
            return false;
        }
        return true;

    }

    public function checkPasswd(string $passwd, string $email):int{
        $stat = $this->database->connection()->prepare('SELECT password, id FROM users WHERE email=?');
        $stat->bindParam(1, $email, PDO::PARAM_STR);
        $stat->execute();
        $res = $stat->fetch();
        $passwd = hash('sha256', $passwd, false);
        if(strcmp($passwd, $res[0]) != 0){
            return -1;
        }
        return $res[1];
    }
}