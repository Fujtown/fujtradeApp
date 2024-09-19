<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapRefunds extends Model
{
    use HasFactory;
    protected $table = 'all_tap_refunds';

    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone', 'refund_id', 'ref_amount', 'ref_currency', 'req_amount', 'req_currency', 'transaction_amount', 'transaction_currency', 'charge_id', 'created', 'date', 'shortcode', 'invoice_id', 'order_id', 'status', 'reason'
        // Add other fields as needed
    ];
}
