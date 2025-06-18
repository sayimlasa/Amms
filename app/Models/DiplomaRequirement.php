<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiplomaRequirement extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name is plural and follows conventions)
    protected $table = 'diploma_requirements';

    // Fillable attributes
    protected $fillable = [
        'programme_id',
        'application_level_id',
        'education_level_id',
        'subject_course',
        'min_advance_pass',
        'min_subsidiary_pass',
    ];

    // Define relationships
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
