<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RegisterUserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

final class AuthService
{
    public function __construct(
        private readonly UserRepository $users,
    ) {}

    public function register(RegisterUserDTO $dto): array
    {
        $user  = $this->users->store($dto);
        $token = (string) Auth::guard("api")->login($user);

        return ["user" => $user, "token" => $token];
    }

    public function login(string $email, string $password): string|false
    {
        $token = Auth::guard("api")->attempt(["email" => $email, "password" => $password]);

        return $token === false ? false : (string) $token;
    }

    public function logout(): void
    {
        Auth::guard("api")->logout();
    }

    public function refresh(): string
    {
        return (string) Auth::guard("api")->refresh();
    }

    public function currentUser(): User
    {
        return Auth::guard("api")->user();
    }

    public function ttl(): int
    {
        return (int) Auth::guard("api")->factory()->getTTL();
    }
}
