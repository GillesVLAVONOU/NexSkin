<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->whereOne('email', $email);
    }

    public function createAdmin(string $name, string $email, string $password): int
    {
        return $this->create([
            'name' => $name,
            'email' => $email,
            'password' => hashPassword($password),
            'role' => 'admin',
        ]);
    }
}
