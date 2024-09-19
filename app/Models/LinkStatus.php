<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkStatus extends Model
{
    use HasFactory;
     protected $table = 'check_link_status';
     
     protected $fillable = ['link_no', 'transaction_id', 'status', 'link_payment'];
}
