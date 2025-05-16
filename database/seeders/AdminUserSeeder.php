<?php

namespace Database\Seeders;

use App\DTOs\User\CreateUserDTO;
use App\Enums\UserType;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = $this->userRepository->create(
            new CreateUserDTO(
                name: 'Administrador',
                email: 'admin@admin',
                password: 'admin'
            )
        );

        $user->type = UserType::Admin;

        $this->userRepository->save($user);
    }
}
