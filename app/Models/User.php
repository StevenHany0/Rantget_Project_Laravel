<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_identify',
        'fullname',
        'email',
        'password',
        'age',
        'phone',
        'image',
        'role',
        'id_identify_image',
        'is_admin' // ✅ تأكدي أنه موجود في قاعدة البيانات
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // ✅ تأكدي أن is_admin يتم التعامل معه كبوليان
    ];

    /**
     * التحقق مما إذا كان المستخدم هو الـ Super Admin
     */
    public function isSuperAdmin()
    {
        return $this->is_admin && $this->email === 'admin@gmail.com';
    }

    /**
     * التحقق مما إذا كان المستخدم Admin
     */
    public function isAdmin()
    {
        return $this->is_admin; // ✅ سيعمل الآن بدون مشاكل
    }

    /**
     * علاقة Many-to-Many مع Property
     */

    // ✅ العقارات التي يملكها المستخدم (كمالك)
    public function ownedProperties()
    {
        return $this->belongsToMany(Property::class, 'property_user')
                    ->wherePivot('role', 'landlord'); // تحقق من استخدام wherePivot إذا كنت تريد جلب بيانات محددة
    }



    // ✅ عدد الشقق التي قام المالك بتأجيرها

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // public function ownedProperties()
    // {
    //     return $this->properties()->wherePivot('role', 'landlord');
    // }



    // سكوب لجلب المستأجرين بسهولة
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }
    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'landlord_id');
    }

    public function tenantContracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }
// في موديل User
public function rentedProperties()
{
    return $this->belongsToMany(Property::class, 'property_user', 'user_id', 'property_id')
                ->wherePivot('role', 'tenant');
}



}





