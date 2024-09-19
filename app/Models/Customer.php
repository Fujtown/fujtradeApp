<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Customer extends Authenticatable

{
    use Notifiable;

    protected $table = 'customers';
    protected $fillable = ['fname','lname','username', 'email','phone','photo','customer_sign', 'password','account_ctype'];

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
