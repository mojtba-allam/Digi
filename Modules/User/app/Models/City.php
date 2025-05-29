<?php

namespace Modules\User\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Database\factories\AddressFactory;
use Modules\User\database\factories\CityFactory;

// use Modules\User\Database\Factories\CityIdFactory;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['city' , 'country_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    protected static function newFactory(): CityFactory
    {
        return CityFactory::new();
    }


}
