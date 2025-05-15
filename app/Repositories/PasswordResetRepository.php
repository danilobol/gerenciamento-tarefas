<?php

namespace App\Repositories;

use App\DTOs\User\ForgotPasswordDTO;
use App\DTOs\User\ResetPasswordDTO;
use App\Models\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetRepository
{
    public function findByResetPasswordDTO(ResetPasswordDTO $dto): ?PasswordReset
    {
        return PasswordReset::where('email', $dto->email)
            ->where('token', $dto->token)
            ->first();
    }

    public function create(ForgotPasswordDTO $dto): PasswordReset
    {
        return PasswordReset::updateOrCreate(
            ['email' => $dto->email],
            ['token' => Str::random(4), 'created_at' => now()]
        );
    }

    public function delete(PasswordReset $passwordReset): void
    {
        $passwordReset->delete();
    }
}
