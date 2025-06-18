<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'index_number',
         'academic_year_id',
        'campus_id',
        'programme_id',
        'intake_id',
        'status',
    ];
}
