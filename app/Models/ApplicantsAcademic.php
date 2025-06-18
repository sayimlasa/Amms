<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantsAcademic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'applicant_academics';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'education_level',
        'course',
        'qualification_no',
        'gpa_divission',
        'yoc',
        'center_name',
        'country_id',
        'region_id',
        'district_id',
    ];

    // Define relationships
    public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function region()
    {
        return $this->belongsTo(RegionState::class, 'region_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
