<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CustomerKycStatus extends Model
{
    use HasFactory;

    // Define the table if it's not the pluralized form of the model name
    protected $table = 'customer_kyc_status';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Specify fillable fields to protect against mass-assignment vulnerabilities
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'link_id',
        'temp_invoice_no',
        'agentID',
        'status',
        'admin_approval'
    ];

    // Define relationships if necessary
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'agentID', 'id');
    }

    public function tapPaymentLink()
    {
        return $this->belongsTo(TapPaymentLink::class, 'link_id', 'id');
    }
}