<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;
    protected $table = 'refund_request';

    protected $fillable = [
        'customer_name', 'email', 'phone', 'refund_amount','agentID','user_type'
        // Add other fields as needed
    ];

    public function agent()
{
    return $this->belongsTo(Admin::class, 'agentID');
}

}
