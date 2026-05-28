<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\RegisterUserDTO;
use App\Models\User;

final class UserRepository
{
    public function store(RegisterUserDTO $dto): User
    {
        return User::create([
            "name"     => $dto->name,
            "email"    => $dto->email,
            "password" => $dto->password,
        ]);
    }
}
