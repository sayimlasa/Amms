<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TamisemiList extends Model
{
        use HasApiTokens, HasFactory;

    use HasFactory;
    protected $fillable = [
        'username', 'fullname', 'application_year', 'programe_name', 
        'institution_name', 'sex', 'date_of_birth', 'phone_number', 
        'email', 'address', 'district', 'region', 'Next_of_kin_fullname', 
        'Next_of_kin_phone_number', 'Next_of_kin_email', 'Next_of_kin_address', 
        'Next_of_kin_region', 'relationship','campus_id','window_id','programme_id',
        'intake_id','academic_year_id','confirm'
     ];
     public function campus()
{
    return $this->belongsTo(Campus::class);
}
}
