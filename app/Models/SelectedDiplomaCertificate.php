<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SelectedDiplomaCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'applicant_user_id',
        'index_no',
        'qualification_no',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'disability',
        'mobile_no',
        'physical_address',
        'campus_id',
        'gender',
        'email',
        'region',
        'district',
        'nationality',
        'next_kin_name',
        'next_kin_address',
        'next_kin_email',
        'next_kin_phone',
        'next_kin_region',
        'next_kin_district',
        'next_kin_relationship',
        'next_kin_nationality',
        'iaa_programme_code',
        'application_year',
        'application_category_id',
        'intake',
        'window',
        'nta_level',
    ];

    public function scopeList($query, $programme_id, $intake, $window, $academicYear, $categoryIds)
    {
        return DB::table('applicants_users')
            ->join('form4_results', 'form4_results.applicant_user_id', '=', 'applicants_users.id')
            ->leftJoin('form6_results', 'form6_results.applicant_user_id', '=', 'applicants_users.id') // Change to left join if necessary
            ->join('applicants_choices', 'applicants_choices.applicant_user_id', '=', 'applicants_users.id')
            ->join('applicants_infos as ai', 'ai.applicant_user_id', '=', 'applicants_users.id')
            ->leftJoin('disabilities', 'ai.disability_id', '=', 'disabilities.id')
            ->leftJoin('regions_states as region_info', 'ai.region_id', '=', 'region_info.id')
            ->leftJoin('districts as district_info', 'ai.district_id', '=', 'district_info.id')
            ->leftJoin('nationalities', 'ai.nationality', '=', 'nationalities.id')
            ->leftJoin('nextof_kins as nk', 'nk.applicant_user_id', '=', 'applicants_users.id')
            ->leftJoin('countries', 'nk.country_id', '=', 'countries.id')
            ->leftJoin('regions_states as region_kin', 'nk.region_id', '=', 'region_kin.id')
            ->leftJoin('districts as district_kin', 'nk.district_id', '=', 'district_kin.id')
            ->leftJoin('relationships', 'nk.relationship_id', '=', 'relationships.id')
            ->where(function ($query) use ($programme_id) {
                $query->where('applicants_choices.choice1', '=', $programme_id)
                    ->orWhere('applicants_choices.choice2', '=', $programme_id)
                    ->orWhere('applicants_choices.choice3', '=', $programme_id);
            })
            ->where('applicants_choices.intake_id', '=', $intake)
            ->whereIn('ai.application_category_id', (array) $categoryIds)
            ->where('applicants_choices.window_id', '=', $window)
            ->where('applicants_choices.academic_year_id', '=', $academicYear)
            ->where('applicants_choices.status', 0)
            ->whereIn('form4_results.grade', ['A', 'B+', 'B', 'C', 'D'])
            ->where('form4_results.status', 1)
            ->select(
                'applicants_users.id as id',
                'ai.fname as fname',
                'ai.mname as mname',
                'ai.lname as lname',
                'ai.birth_date as dob',
                'disabilities.name as disability',
                'ai.gender as gender',
                'ai.physical_address as physical_address',
                'applicants_users.index_no as index_no',
                'applicants_users.mobile_no as mobile_no',
                'applicants_users.email as email',
                'ai.campus_id as campus',
                'region_info.name as region_info',
                'district_info.name as district_info',
                'countries.name as country_name',
                'region_kin.name as region_kin',
                'district_kin.name as district_kin',
                'nk.physical_address as next_keen_address',
                'nk.mobile_no as next_keen_mobile',
                'nk.email as next_keen_email',
                'relationships.name as relation',
                'nationalities.name as nation',
                'ai.application_category_id as categoryId',
                DB::raw("GROUP_CONCAT(DISTINCT form6_results.qualification_no SEPARATOR ', ') as qualification_no"),  // Concatenate qualifications
                DB::raw("CONCAT(nk.fname, ' ', COALESCE(nk.mname, ''), ' ', nk.lname) as next_of_kin_fullname"),
                DB::raw("
                    CASE
                        WHEN applicants_choices.choice1 = ? THEN applicants_choices.choice1
                        WHEN applicants_choices.choice2 = ? THEN applicants_choices.choice2
                        WHEN applicants_choices.choice3 = ? THEN applicants_choices.choice3
                        ELSE NULL
                    END as programme_id
                "),
                DB::raw('COUNT(CASE WHEN form4_results.status = 1 THEN 1 END) as status_count')
            )
            ->groupBy([
                'applicants_users.id',
                'applicants_users.index_no',
                'ai.fname',
                'ai.mname',
                'ai.lname',
                'ai.gender',
                'nk.fname',
                'nk.mname',
                'nk.lname',
                'applicants_choices.choice1',
                'applicants_choices.choice2',
                'applicants_choices.choice3',
                'ai.birth_date',
                'disabilities.name',
                'applicants_users.email',
                'applicants_users.mobile_no',
                'ai.physical_address',
                'ai.campus_id',
                'region_info.name',
                'district_info.name',
                'nationalities.name',
                'countries.name',
                'region_kin.name',
                'district_kin.name',
                'nk.physical_address',
                'nk.mobile_no',
                'nk.email',
                'relationships.name',
                'ai.application_category_id',
                'programme_id',
            ])
            ->havingRaw('status_count >= 4')
            ->distinct()
            ->addBinding($programme_id, 'select')  // Add binding for programme_id
            ->addBinding($programme_id, 'select')  // Add binding for choice2
            ->addBinding($programme_id, 'select')  // Add binding for choice3
            ;
    }
}
