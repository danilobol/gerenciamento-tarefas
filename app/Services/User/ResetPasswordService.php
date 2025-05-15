<?php

namespace App\Services\User;

use App\DTOs\User\ResetPasswordDTO;
use App\Models\User;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;

class ResetPasswordService
{
    public function __construct(
        private PasswordResetRepository $passwordResetRepository,
        private UserRepository $userRepository,
    ) {
    }

    public function execute(ResetPasswordDTO $dto): User
    {
        $passwordReset = $this->passwordResetRepository->findByResetPasswordDTO($dto);

        if (! $passwordReset || $passwordReset->created_at->addHour() < now()) {
            throw new \InvalidArgumentException('Token inválido ou expirado');
        }

        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user) {
            throw new \InvalidArgumentException('Não conseguimos recuperar seu usuário, favor comunicar ao suporte !');
        }

        $this->passwordResetRepository->delete($passwordReset);

        return $this->userRepository->save($user->setPassword($dto->password));
    }
}
