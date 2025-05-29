<?php

namespace Modules\User\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\User\Database\factories\AddressFactory;
use Modules\User\database\factories\CountryFactory;

// use Modules\User\Database\Factories\CountryIdFactory;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['country'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }
}
