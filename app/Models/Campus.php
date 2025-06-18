<?php

namespace App\Models;

use App\Models\ApplicantsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'country_id',
        'region_state_id',
        'district_id',
        'active'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function region_state()
    {
        return $this->belongsTo(RegionState::class, 'region_state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function campusProgrammes()
    {
        return $this->belongsToMany(Programme::class);
    }

    public function campusLevels()
    {
        return $this->belongsToMany(ApplicationLevel::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
       // Define the relationship between Campus and Applicant (one-to-many)
       public function applicants()
       {
           return $this->hasMany(ApplicantsInfo::class); // Assuming Applicant has a campus_id
       }
}
