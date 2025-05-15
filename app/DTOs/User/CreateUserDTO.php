<?php

namespace App\DTOs\User;

use App\Http\Requests\RegisterUserRequest;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
    }

    public static function fromRegisterUserRequest(RegisterUserRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
        );
    }
}
