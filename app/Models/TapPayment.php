<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapPayment extends Model
{
    use HasFactory;
    protected $table = 'all_tap_payment';

    protected $fillable = [
        'amount', 'brand', 'ch_id', 'code', 'country_code', 'currency',
        'customer_id', 'date', 'email', 'first_name', 'invoice_id', 'last_name',
        'message', 'number', 'payment', 'receipt', 'status', 'tr_id', 'track','short_code'
        // Add other fields as needed
    ];
}
