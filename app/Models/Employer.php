<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile_no',
        'email',
        'address',
        'emp_status_id',
    ];

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'emp_status_id');
    }
}
