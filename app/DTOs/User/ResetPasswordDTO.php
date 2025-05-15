<?php

namespace App\DTOs\User;

use App\Http\Requests\ResetPasswordRequest;

readonly class ResetPasswordDTO
{
    public function __construct(
        public string $email,
        public string $token,
        public string $password,
    ) {
    }

    public static function fromResetPasswordRequest(ResetPasswordRequest $request): self
    {
        return new self(
            email: $request->input('email'),
            token: $request->input('token'),
            password: $request->input('password'),
        );
    }
}
