<?php

namespace App\Repositories;

use App\DTOs\User\CreateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(CreateUserDTO $dto): User
    {
        return User::create([
            'email' => $dto->email,
            'name' => $dto->name,
            'password' => Hash::make($dto->password)
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }
}
