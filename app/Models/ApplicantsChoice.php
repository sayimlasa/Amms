<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantsChoice extends Model
{
    use HasFactory;
    public function applicationLevel()
    {
        return $this->belongsTo(ApplicationLevel::class, 'application_level_id');
    }
}
