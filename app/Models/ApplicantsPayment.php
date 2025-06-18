<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantsPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'control_number', 'name','billId', 'index_id', 'amount', 'date_requested','date_paid'
    ];
}
