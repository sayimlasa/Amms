<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_level_id',
        'education_level_id',
        'subject_course',
    ];

    public function application_level(){
        return $this->belongsTo(ApplicationLevel::class, 'application_level_id');
    }

    public function education_level(){
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }
}
