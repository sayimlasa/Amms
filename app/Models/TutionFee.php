<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutionFee extends Model
{
    use HasFactory;
    protected $fillable = ['level_id', 'amount', 'computing'];

}
