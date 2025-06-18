<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'control_no',
        'billId',
        'index_no',
        'amount',
        'date_requested',
    ];
}
