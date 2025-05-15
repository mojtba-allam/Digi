<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\Models\User;

// use Modules\User\Database\Factories\AddressFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'address', 'city', 'country'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
