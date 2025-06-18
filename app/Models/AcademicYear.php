<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_at', 
        'end_at', 
        'active'
    ];
    public function applicantsInfo()
{
    return $this->hasMany(ApplicantsInfo::class, 'acadmic_year_id');
}

}
