<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_user_id', 
        'index_no', 
        'type_id', 
        'doc_url'
    ];

    public function applicantUser()
    {
        return $this->belongsTo(ApplicantsUser::class, 'applicant_user_id');
    }

    public function type()
    {
        return $this->belongsTo(AttachmentType::class, 'type_id');
    }
}
