<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyQualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'studymode',
        'blended',
        'necta_iv',
        'necta_vi',
        'diploma',
        'bachelor_certificate',
        'bachelor_transcript',
        'medical_form',
        'birth_certificate',
        'regno',
    ];

    // Optionally, you can define custom table name if it's not following conventions
    protected $table = 'verify_qualifications';
}
