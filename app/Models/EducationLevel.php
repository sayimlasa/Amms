<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'active'
    ];
    
    public function educationLevelCategories()
    {
        return $this->belongsToMany(ApplicationCategory::class, 'education_category', 'education_level_id', 'application_category_id');
    }  
}
