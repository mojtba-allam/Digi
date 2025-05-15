<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\PromotionAndCoupon\Models\Promotion;

// use Modules\Product\Database\Factories\ProductMediaFactory;

class ProductMedia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_id', 'media_type', 'url', 'product_variant_id', 'promotion_id', 'media_order', 'alt_text', 'caption'];

    public function product_variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    // protected static function newFactory(): ProductMediaFactory
    // {
    //     // return ProductMediaFactory::new();
    // }
}
