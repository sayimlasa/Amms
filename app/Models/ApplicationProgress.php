<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'academic_year_id',
        'application_step',
        'status',
    ];

    // Define relationship to applicants_users table
    public function user()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }

    // Define relationship to academic_years table
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
