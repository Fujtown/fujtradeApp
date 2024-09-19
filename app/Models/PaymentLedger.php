<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLedger extends Model
{
    use HasFactory;
      protected $table = 'payment_ledger';
     
     protected $fillable = ['amount', 'currency', 'date', 'email', 'full_name', 'transaction_no','source_table'];
     
       public function foloosi()
    {
        // Replace 'foreign_key', 'local_key' with the actual column names
        return $this->hasOne(Foloosi::class, 'transaction_no', 'transaction_no');
    }
       public function NoonTransaction()
    {
        // Replace 'foreign_key', 'local_key' with the actual column names
        return $this->hasOne(NoonTransaction::class, 'tr_id', 'transaction_no');
    }
    
     public function PaymentByLink()
    {
        // Replace 'foreign_key', 'local_key' with the actual column names
        return $this->hasOne(PaymentByLink::class, 'ch_id', 'transaction_no');
    }

}
