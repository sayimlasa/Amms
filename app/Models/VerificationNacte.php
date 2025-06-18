<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationNacte extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'user_id',
        'verification_status',
        'multiple_selection',
        'academic_year',
        'intake',
        'eligibility',
        'remarks',
        'status',
        'programme_id',
        'campus_id',
        'intake_id',
        'academic_year_id',
        'window_id',
    ];
}
