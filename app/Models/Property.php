<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Contract;
use App\Models\User;

class Property extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'description',
        'image',
        'location',
        'price',
        'status',
    ];

    /**
     * جميع المستخدمين المرتبطين بالعقار (ملاك ومستخدمين آخرين)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'property_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * الملاك (landlords) المرتبطين بالعقار
     */
    public function landlords()
    {
        return $this->belongsToMany(User::class, 'property_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'landlord')
                    ->withTimestamps();
    }

    /**
     * المستأجرين (tenants) المرتبطين بالعقار
     */
    public function tenants()
    {
        return $this->belongsToMany(User::class, 'property_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'tenant')
                    ->withTimestamps();
    }

    /**
     * العقود المرتبطة بالعقار
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'property_id');
    }

    /**
     * عقود التأجير المرتبطة (نفس contracts)
     */
    public function rentals()
    {
        return $this->hasMany(Contract::class, 'property_id');
    }
}
