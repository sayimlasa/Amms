<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgrammeNacte extends Model
{
    use HasFactory;
    protected $fillable =[

    'program_id',
    'program_name',
    'dar_program',
    'dar_program_id',
    'nta',
    'campus_id'
    ];
    public function scopeList()
    {
        return DB::table('programme_nactes')
            ->join('selected_diploma_certificates as dip', 'programme_nactes.iaa_program_id', '=', 'dip.iaa_programme_code')
             ->select(['dip.application_year as application_year','dip.first_name as first_name','dip.middle_name as middle_name' ,'dip.last_name as last_name',
             'dip.dob as dob','dip.gender as gender','dip.disability as disability','dip.email as email','dip.mobile_no as mobile_no',
             'dip.physical_address as physical_address','dip.region as region','dip.district as district','dip.nationality as nationality','dip.qualification_no as qualification_no',
             'dip.next_kin_name as next_kin_name','dip.next_kin_address as next_kin_address','dip.next_kin_email as next_kin_email','dip.next_kin_region as next_kin_region','dip.index_no as index_no',
             'dip.next_kin_district as next_kin_district','next_kin_nationality as next_kin_nationality','dip.next_kin_relationship as next_kin_relationship','dip.next_kin_phone as next_kin_phone',
             'programme_nactes.program_id as program_nacte_id']);
    }
}
