<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPdf extends Model
{
    use HasFactory;
    protected $table = 'customer_pdfs';

    protected $fillable = [
        'email', 'pdf_url'        // Add other fields as needed
    ];
}
