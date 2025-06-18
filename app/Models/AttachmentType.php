<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'active',
    ];

    public function attachmentTypesCategories()
    {
        return $this->belongsToMany(ApplicationCategory::class, 'attachment_category', 'attachment_type_id', 'application_category_id');
    } 
}
