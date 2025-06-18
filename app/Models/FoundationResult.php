<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundationResult extends Model
{
    use HasFactory;
       protected $fillable = [
        'reg_no',
        'index_no',
        'first_name',
        'mid_name',
        'surname',
        'gender',
        'birth_date',
        'academic_year',
        'gpa',
        'classification',
        'subject_code',
        'subject_name',
        'grade',
        'status',
        'status_description',
    ];
     public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }
}
