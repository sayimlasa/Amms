<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationCategory extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'application_level_id',
        'active'
    ];

    public function application_level(){
        return $this->belongsTo(ApplicationLevel::class, 'application_level_id');
    }

    public function educationLevels()
    {
        return $this->belongsToMany(EducationLevel::class, 'education_category');
    }

    public function attachmentTypes()
    {
        return $this->belongsToMany(AttachmentType::class, 'attachment_category');
    }
}
