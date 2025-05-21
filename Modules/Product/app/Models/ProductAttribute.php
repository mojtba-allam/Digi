<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Product\database\factories\ProductAttributeFactory;

// use Modules\Product\database\factories\ProductAttributeFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_id', 'key', 'value'];

    public function product_variants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): ProductAttributeFactory
    {
        return ProductAttributeFactory::new();
    }
}
