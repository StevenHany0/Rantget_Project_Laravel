<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Contract;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'user_id', 'action_type', 'old_data', 'new_data'];

    public function contract()
    {
        return $this->belongsTo(Contract::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
