<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $fillable = ['username', 'email', 'password'];

        // If you have a different name for the 'remember_token' field, specify it here
protected $rememberTokenName = 'remember_token';
protected $hidden = [
    'password',
    'remember_token',
];
protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];

}
