<?php

namespace App\DTOs\User;

use App\Http\Requests\ForgotPasswordRequest;

readonly class ForgotPasswordDTO
{
    public function __construct(
        public string $email,
    ) {
    }

    public static function fromForgotPasswordRequest(ForgotPasswordRequest $request): self
    {
        return new self(
            email: $request->input('email'),
        );
    }
}
