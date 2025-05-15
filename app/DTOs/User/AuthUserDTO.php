<?php

namespace App\DTOs\User;

use Illuminate\Contracts\Auth\Authenticatable;

readonly class AuthUserDTO implements \JsonSerializable
{
    public function __construct(
        public string $token,
        public int $expiresIn = 0,
        public ?Authenticatable $user = null,
    ) {
    }

    public static function fromToken(string $token): AuthUserDTO
    {
        return new self(
            token: $token,
            expiresIn: auth()->factory()->getTTL() * 60000,
            user: auth()->user(),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'expiresIn' => $this->expiresIn,
            'user' => $this->user,
        ];
    }
}
