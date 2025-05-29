<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Authorization\app\Models\User;
use Modules\User\database\factories\AddressFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'address', 'city_id', 'country_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function city(): HasOne
    {
        return $this->hasOne (City::class);
    }
}
