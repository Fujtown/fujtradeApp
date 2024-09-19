<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refunds extends Model
{
    use HasFactory;
    protected $table = 'tap_refunds';

    protected $fillable = [
        'Refund_req_date', 'Refund_date', 'ch_id', 'ref_id', 'merchent_id', 'code',
        'country_code', 'currency', 'customer_id', 'date',
        'email', 'first_name', 'invoice_id', 'last_name', 'message', 'number',
        'country_amount', 'exchange_amount', 'reason', 'receipt', 'status', 'track'
        // Add other fields as needed
    ];
}
