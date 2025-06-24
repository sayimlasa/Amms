<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAttachment extends Model
{
    use HasFactory;
      protected $fillable = [
        'serial_number',
        'derivery_note_number',
        'invoice_no',
        'derivery_note_attachment',
        'invoice_number_attachment',
        // add any other fillable fields
    ];
}
