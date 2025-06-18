<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable =[
        'iaa_code',
        'tcu_code',
        'nacte_code',
        'name',
        'intake_id',
        'application_level_id',
        'active',
        'short',
        'computing'
    ];

    public function application_level(){
        return $this->belongsTo(ApplicationLevel::class, 'application_level_id');
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'campus_programme');
    }

    public function intakes()
    {
        return $this->belongsToMany(Intake::class, 'intake_programme');
    }
}
