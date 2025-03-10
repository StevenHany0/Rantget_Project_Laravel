<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'card_number',
         'expiry_date',
         'cvv',
         'amount',
         'payment_date'
    ];

    protected $attributes = [
        'payment_method' => 'Visa',
    ];

    public function contract() {
        return $this->belongsTo(Contract::class);
    }
}
