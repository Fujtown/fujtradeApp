<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoonTransaction extends Model
{
    use HasFactory;
      protected $table = 'noon_transactions';

    protected $fillable = [
        'tr_id','amount', 'currency', 'first_name', 'last_name', 'phone',
        'email', 'status', 'date', 'message', 'reference', 'mode',
        'intAccount', 'paymentInfo', 'brand', 'expiryMonth', 'expiryYear', 'cardCountry', 'cardCountryName','cardIssuerName','agentID'
        // Add other fields as needed
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
