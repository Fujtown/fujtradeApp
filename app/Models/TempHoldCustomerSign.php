<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempHoldCustomerSign extends Model
{
    use HasFactory;
    
    protected $table = 'temp_hold_customersign';
    protected $fillable = ['customer_name','customer_email','customer_sign'];

}
