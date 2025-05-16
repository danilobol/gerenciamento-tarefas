<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Support\Facades\Hash;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Override;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, \JsonSerializable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected string $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserType::class,
        'status' => UserStatus::class,
    ];

    protected $attributes = [
        'type' => UserType::Common,
        'status' => UserStatus::Active,
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'user' => [
                'id'    => $this->getKey(),
                'email' => $this->getAttribute('email'),
                'name'  => $this->getAttribute('name'),
                'type'  => $this->getTypeAttribute($this->getAttribute('type'))->value,
                'status'  => $this->isAtivo(),
            ],
        ];
    }

    public function setPassword(string $password): self
    {
        $this->password = Hash::make($password);

        return $this;
    }

    public function getTypeAttribute($value): UserType
    {
        if ($value instanceof UserType) {
            return $value;
        }

        return $value ? UserType::from($value) : UserType::Common;
    }

    public function isAtivo(): bool
    {
        return $this->getAttribute('status') !== UserStatus::Blocked ||
            $this->getAttribute('status') !== UserStatus::Inactive;
    }

    public function isAdmin(): bool
    {
        return $this->getAttribute('type') === UserType::Admin;
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->getKey(),
            'email' => $this->getAttribute('email'),
            'name'  => $this->getAttribute('name'),
            'type'  => $this->getTypeAttribute($this->getAttribute('type'))->value,
            'status'  => $this->isAtivo(),
        ];
    }
}
