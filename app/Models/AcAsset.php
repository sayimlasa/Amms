<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcAsset extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial_number',
        'reference_number',
        'supplier_id',
        'brand_id',
        'warranty_expiry_date',
        'warranty_number',
        'model',
        'type',
        'capacity',
        'derivery_note_number',
        'derivery_note_date',
        'lpo_no',
        'invoice_date',
        'invoice_no',
        'installation_date',
        'installed_by',
        'condition',
        'status',
        'location_id',
        'justification_form_no',
        'created_by',
    ];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
