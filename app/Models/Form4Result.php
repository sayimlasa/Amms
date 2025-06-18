<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form4Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'subject_code',
        'subject_name',
        'marks',
        'grade',
        'status',
    ];

    // Relationships
    public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }
}
