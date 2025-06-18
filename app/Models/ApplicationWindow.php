<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationWindow extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'application_level_id',
        'intake_id',
        'academic_year_id',
        'start_at',
        'end_at',
        'active'
    ];

    public function application_level(){
        return $this->belongsTo(ApplicationLevel::class, 'application_level_id');
    }

    public function intake(){
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
