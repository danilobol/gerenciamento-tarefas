<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'password_resets';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
