<?php
declare(strict_types=1);

namespace Salle\LSocial\Model;

use DateTime;

final class User
{
    private int $id;
    private string $email;
    private string $password;
    private String $birthday;
    #created i modified no es fan servir


    public function __construct(string $email,string $password,string $birthday,)
    {
        $this->email = $email;
        $this->password = hash('sha256', $password, false);
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }


}
