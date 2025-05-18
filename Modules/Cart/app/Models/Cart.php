<?php

namespace Modules\Cart\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Authorization\app\Models\User;
use \Modules\PromotionAndCoupon\app\Models\Coupon;
use Modules\Product\app\Models\Product;


class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    protected static function newFactory()
    {
         return \Modules\Cart\Database\factories\CartFactory::new();
    }
}
