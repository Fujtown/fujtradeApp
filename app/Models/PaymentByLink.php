<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentByLink extends Model
{
    use HasFactory;
    protected $table = 'payment_by_link';

    protected $fillable = [
        'amount', 'brand', 'ch_id', 'code', 'country_code', 'currency',
        'customer_id', 'date', 'email', 'first_name', 'invoice_id', 'last_name',
        'message', 'number', 'payment', 'receipt', 'status', 'tr_id', 'track','agentID'
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
