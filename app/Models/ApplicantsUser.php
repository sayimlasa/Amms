<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class ApplicantsUser extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'index_no',
        'email',
        'password',
        'mobile_no',
        'active',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'acadmic_year_id');
    }

    public function applicantInfo()
    {
        return $this->hasOne(ApplicantsInfo::class, 'applicant_user_id');
    }
     // Define the inverse relationship (an applicant belongs to a campus)
     public function campus()
     {
         return $this->belongsTo(Campus::class); // Assuming each applicant belongs to a campus
     }
}
