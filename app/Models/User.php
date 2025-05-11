<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_identify',
        'fullname',
        'email',
        'email_verified_at',
        'password',
        'age',
        'phone',
        'image',
        'role',
        'id_identify_image',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // التحقق مما إذا كان المستخدم هو Super Admin
    public function isSuperAdmin()
    {
        return $this->is_admin && $this->email === 'admin@gmail.com';
    }

    // التحقق مما إذا كان المستخدم Admin
    public function isAdmin()
    {
        return $this->is_admin;
    }

    // العقارات التي يملكها المستخدم (كمالك)
    public function ownedProperties()
    {
        return $this->belongsToMany(Property::class, 'property_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'landlord')
                    ->withTimestamps();
    }

    // جميع العقارات المرتبطة بالمستخدم مع الدور (مالك أو مستأجر)
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // سكوب لجلب المستأجرين
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }

    // سكوب لجلب الملاك
    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }

    // العقود التي يملكها المستخدم كمالك
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'landlord_id');
    }

    // العقود التي اشترك بها كمستأجر
    public function tenantContracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    // العقارات التي استأجرها المستخدم
    public function rentedProperties()
    {
        return $this->belongsToMany(Property::class, 'contracts', 'tenant_id', 'property_id');
    }
}
