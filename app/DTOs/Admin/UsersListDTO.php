<?php

namespace App\DTOs\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class UsersListDTO implements \JsonSerializable
{
    public function __construct(
        public Collection $users,
        public array $pagination,
    )
    {
    }

    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            users: $paginator->getCollection()->map(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->isAtivo(),
            ]),

            pagination: [
                'total' => $paginator->total(),
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
            ]
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => $this->users,
            'meta' => $this->pagination
        ];
    }
}
