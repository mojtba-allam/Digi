<?php

namespace Modules\PromotionAndCoupon\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\app\Models\ProductMedia;
use Modules\PromotionAndCoupon\database\factories\PromotionFactory;


class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function discount_rules(): HasMany
    {
        return $this->hasMany(DiscountRule::class);
    }

    public function product_medias(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }



    protected static function newFactory(): PromotionFactory
    {
        return PromotionFactory::new();
    }
}
