<?php

namespace App\Services\User;

use App\DTOs\User\AuthUserDTO;
use App\DTOs\User\LoginUserDTO;

class LoginUserService
{
    public function execute(LoginUserDTO $loginUserDTO): AuthUserDTO
    {
        if ($token = auth()->attempt(['email' => $loginUserDTO->email, 'password' => $loginUserDTO->password]))
        {
            return AuthUserDTO::fromToken($token);
        } else {
            throw new \InvalidArgumentException('Unauthorized user!');
        }
    }
}
