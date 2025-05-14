<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Authorization\Models\User;

// use Modules\User\Database\Factories\AddressFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'address', 'city', 'country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
