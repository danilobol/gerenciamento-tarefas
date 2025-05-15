<?php

namespace App\Services\User;

use App\DTOs\User\ForgotPasswordDTO;
use App\Models\PasswordReset;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;

readonly class ForgotPasswordService
{
    private const string MENSAGEM_EMAIL_INVALIDO = 'Não conseguimos recuperar a senha para email "%s", verifique novamente!';
    public function __construct(
        private UserRepository $userRepository,
        private PasswordResetRepository $passwordResetRepository,
    ) {
    }

    public function execute(ForgotPasswordDTO $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user) {
            throw new \InvalidArgumentException(sprintf(self::MENSAGEM_EMAIL_INVALIDO, $dto->email));
        }

        $passwordReset = $this->passwordResetRepository->create($dto);

        //falta implementar envio do token por email (lançar job)
    }
}
