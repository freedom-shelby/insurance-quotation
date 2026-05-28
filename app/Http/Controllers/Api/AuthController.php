<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        ['user' => $user, 'token' => $token] = $this->auth->register(
            new RegisterUserDTO(
                name: $request->validated('name'),
                email: $request->validated('email'),
                password: $request->validated('password'),
            )
        );

        return response()->json([
            'message' => 'User registered successfully.',
            'user'    => $user,
            'token'   => $this->tokenPayload($token),
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->auth->login(
            $request->validated('email'),
            $request->validated('password'),
        );

        if ($token === false) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        return response()->json([
            'message' => 'Login successful.',
            'token'   => $this->tokenPayload($token),
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->auth->logout();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'token' => $this->tokenPayload($this->auth->refresh()),
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json($this->auth->currentUser());
    }

    private function tokenPayload(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->auth->ttl() * 60,
        ];
    }
}
