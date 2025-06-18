<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region_state_id'
    ];

    public function region_state(){
        return $this->belongsTo(RegionState::class, 'region_state_id');
    }
}
