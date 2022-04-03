<?php
declare(strict_types=1);

namespace Salle\LSocial\Model;

interface UserRepository
{
    public function save(User $user): void;
    public function checkEmailExists(string $email): bool;
}