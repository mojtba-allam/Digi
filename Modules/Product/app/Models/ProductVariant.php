<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\app\Models\ReturnRequest;

// use Modules\Product\Database\Factories\ProductVariantFactory;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['variant_type', 'value', 'sku', 'price', 'stock', 'product_id', 'product_media_id'];

    public function return_requests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function product_media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function product_attribute(): BelongsToMany
    {
        return $this->belongsToMany(ProductAttribute::class);
    }

    // protected static function newFactory(): ProductVariantFactory
    // {
    //     // return ProductVariantFactory::new();
    // }
}
