<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function intakeProgrammes()
    {
        return $this->belongsToMany(Programme::class);
    }
}
