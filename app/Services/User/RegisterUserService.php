<?php

namespace App\Services\User;

use App\DTOs\User\AuthUserDTO;
use App\DTOs\User\CreateUserDTO;
use App\Repositories\UserRepository;

readonly class RegisterUserService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function execute(CreateUserDTO $dto): AuthUserDTO
    {
        $user = $this->userRepository->create($dto);

        if (! $token = auth()->login($user)){
            throw new \InvalidArgumentException('Unauthorized user, invalid data!');
        }

        return AuthUserDTO::fromToken($token);
    }
}
