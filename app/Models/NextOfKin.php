<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    use HasFactory;
    protected $table = 'nextof_kins';
    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'fname',
        'mname',
        'lname',
        'email',
        'mobile_no',
        'country_id',
        'region_id',
        'district_id',
        'physical_address',
        'relationship_id',
        'nationality',
    ];

    // Define relationships
    public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
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

    public function relationship()
    {
        return $this->belongsTo(Relationship::class, 'relationship_id');
    }
    public function nationalit(){

        return $this->belongsTo(Nationality::class, 'nationality');
    }
}
