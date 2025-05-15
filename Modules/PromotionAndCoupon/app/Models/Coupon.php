<?php

namespace Modules\PromotionAndCoupon\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cart\app\Models\Cart;

// use Modules\PromotionAndCoupon\Database\Factories\CouponFactory;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['code', 'discount', 'usage_limit'];

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }

    // protected static function newFactory(): CouponFactory
    // {
    //     // return CouponFactory::new();
    // }
}
