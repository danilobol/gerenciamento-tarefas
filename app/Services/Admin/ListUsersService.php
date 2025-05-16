<?php

namespace App\Services\Admin;

use App\DTOs\Admin\UsersListDTO;
use App\Repositories\UserRepository;

readonly class ListUsersService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function execute(): UsersListDTO
    {
        return UsersListDTO::fromPaginator($this->userRepository->listPaginated());
    }
}
