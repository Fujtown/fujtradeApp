<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foloosi extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'transaction_no', 'receipt', 'request_currency', 'request_amount',
        'customer_currency', 'customer_amount', 'merchant_currency', 'merchant_amount',
        'status', 'payment_failed_reason', 'created_at_foloosi', 'optional1', 'optional2',
        'optional3', 'subscription_no', 'customer_name', 'customer_email',
        'customer_phone_number', 'pan', 'card_type', 'bin_card', 'issuer_name',
        'issuer_country', 'card_expiry', 'holder_name', 'card_reference', 'card_id',
        'card_bin', 'bin_bank', 'bin_type', 'bin_level', 'bin_country_code', 'bin_website',
        'bin_phone', 'bin_valid', 'card_issuer','agentID'
        // Add more fields as necessary
    ];
    

  public function agent()
    {
        return $this->belongsTo(Admin::class, 'agentID');
    }
    
  public function admin()
    {
        // Assume each Foloosi record belongs to an Admin
        // Replace 'admin_id' with the actual foreign key column from the Foloosi table
        // that connects to the 'id' column of the Admin table
        return $this->belongsTo(Admin::class, 'agentID', 'id');
    }
   
    
}


