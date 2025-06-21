<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'ac_id',
        'from_location_id',
        'to_location_id',
        'movement_type',
        'moved_by',
        'remark',
    ];

    /**
     * Get the location the asset moved from.
     */
    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    /**
     * Get the location the asset moved to.
     */
    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    /**
     * Get the user who moved the asset.
     */
    public function movedBy()
    {
        return $this->belongsTo(User::class, 'moved_by');
    }

    public function acAsset()
    {
        return $this->belongsTo(AcAsset::class, 'ac_id');
    }
}
