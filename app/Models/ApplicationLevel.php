<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLevel extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'nta_level',
        'active'
    ];

    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'campus_level');
    }
    public function applicantsChoices()
    {
        return $this->hasMany(ApplicantsChoice::class, 'application_level_id'); // Assuming 'application_level_id' in ApplicantsChoice
    }
}
