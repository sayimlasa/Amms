<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantsInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'fname',
        'mname',
        'lname',
        'gender',
        'birth_date',
        'cob_id',
        'pob_id',
        'dob_id',
        'nationality',
        'marital_status_id',
        'physical_address',
        'country_id',
        'region_id',
        'district_id',
        'acadmic_year_id',
        'intake_id',
        'application_category_id',
        'campus_id',
        'employment_status',
        'employer_id',
        'disability_id',
    ];

    // Relationships
    public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }

    public function applicationCategory()
    {
        return $this->belongsTo(ApplicationCategory::class, 'application_category_id');
    }

    public function countryOfBirth()
    {
        return $this->belongsTo(Country::class, 'cob_id');
    }

    public function placeOfBirth()
    {
        return $this->belongsTo(RegionState::class, 'pob_id');
    }

    public function districtOfBirth(){
        return $this->belongsTo(District::class, 'dob_id');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id');
    }

    public function region()
    {
        return $this->belongsTo(RegionState::class, 'region_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'acadmic_year_id');
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function nationalit(){

        return $this->belongsTo(Nationality::class, 'nationality');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function disability()
    {
        return $this->belongsTo(Disability::class, 'disability_id');
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status');
    }
}
