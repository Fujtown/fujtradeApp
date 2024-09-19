<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllFoloosiPayments extends Model
{
    use HasFactory;
    
    
    protected $table = 'all_foloosi_payment';
    protected $fillable = ['transaction_no', 'sender_id', 'receiver_id', 'payment_link_id', 'send_amount', 'sender_currency', 'tip_amount', 'receive_currency', 'special_offer_applied', 'sender_amount', 
    'receive_amount', 'offer_amount', 'vat_amount', 'transaction_type', 'poppay_fee', 'transaction_fixed_fee', 'customer_foloosi_fee', 'status',
    'created', 'sender_name', 'sender_email', 'sender_business_name', 'sender_phone_number'];
}
