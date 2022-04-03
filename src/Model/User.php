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
        $this->password = $password;
        $this->birthday = $birthday; #si es null ja es mirarà a la bbdd
    }
}
