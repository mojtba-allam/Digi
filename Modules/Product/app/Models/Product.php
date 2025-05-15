<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Business\app\Models\Vendor;
use Modules\Cart\app\Models\Cart;
use Modules\Category\app\Models\Brand;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Models\Collection;
use Modules\List\app\Models\Wishlist;
use Modules\Order\app\Models\OrderItem;
use Modules\Reaction\app\Models\Review;

// use Modules\Product\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description', 'price', 'stock', 'status', 'vendor_id'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }

    public function product_variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function product_media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function product_attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist_items(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }

    // protected static function newFactory(): ProductFactory
    // {
    //     // return ProductFactory::new();
    // }
}
