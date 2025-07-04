<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionState extends Model
{
    use HasFactory;
    protected $table = 'regions_states';
    
    protected $fillable = [
        'name', 
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
