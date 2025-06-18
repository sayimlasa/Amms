<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BachelorRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'programme_id',
        'application_level_id',
        'education_level_id',
        'subject_course',
        'min_olevel_pass',
        'min_olevel_average',
        'min_foundation_gpa',
        'min_advance_principle_pass',
        'min_advance_aggregate_points',
        'math',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function applicationLevel()
    {
        return $this->belongsTo(ApplicationLevel::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
