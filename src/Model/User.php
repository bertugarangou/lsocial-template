<?php
declare(strict_types=1);

namespace Salle\LSocial\Model;

use DateTime;

final class User
{
    private int $id;
    private string $email;
    private string $password;
    private DateTime $birthday;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        string   $email,
        string   $password,
        DateTime $birthday,
        DateTime $createdAt,
        DateTime $updatedAt
    )
    {
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;

        if(strlen($birthday->format('Y-m-d H:i:s')) == 0){#si no hi ha birthday
            $birthday = NULL;
        }
        $this->birthday = $birthday;


    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function birthday(): DateTime
    {
        return $this->birthday;
    }
}
