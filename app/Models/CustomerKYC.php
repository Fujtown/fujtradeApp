<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerKYC extends Model
{
    use HasFactory;
    protected $table = 'customer_kyc';
    protected $fillable = ['customer_name', 'zip_file_name','invoice_no','agentID','temp_inv_no'];

    public function agent()
    {
        return $this->belongsTo(Admin::class, 'agentID');
    }
}
