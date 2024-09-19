<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapPaymentLink extends Model
{
    use HasFactory;
    protected $table = 'tap_payment_link';

      protected $fillable = [
        'agentID','amount', 'currency', 'payment_type', 'url', 'random_no','link_payment','agentID','temp_inv_no'
        // Add other fields as needed
    ];

    public function agent()
    {
        return $this->belongsTo(Admin::class, 'agentID');
    }
}
