<?php

namespace App\Models;

use App\Traits\Auditable;  // Ensure this points to the correct path
use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Campus;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasFactory, HasApiTokens;

    public $table = 'users';

    public static $searchable = [
        'active',
    ];

    protected $hidden = [
        'remember_token', 'two_factor_code', 'password',
    ];

    protected $dates = [
        'email_verified_at', 'created_at', 'updated_at', 'two_factor_expires_at',
    ];

    protected $fillable = [
        'username', 'name', 'mobile', 'campus_id', 
        'two_factor', 'email', 'two_factor_code', 'password', 'email_verified_at', 
        'remember_token', 'active', 'created_at', 'updated_at', 'two_factor_expires_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
        $this->timestamps = true; // Restore timestamps
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class);
    }
}
