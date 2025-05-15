<?php

namespace App\DTOs\User;

use App\Http\Requests\LoginRequest;

readonly class LoginUserDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    public static function fromLoginRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
        );
    }
}
