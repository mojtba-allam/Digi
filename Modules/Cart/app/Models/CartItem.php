<?php

namespace Modules\Cart\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\app\Models\Product;
use Modules\Cart\database\factories\CartItemFactory;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'product_variant_id',
        'options'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'options' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the cart item.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant if applicable.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(\Modules\Product\app\Models\ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the total price for this cart item.
     */
    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Get the display name for the cart item.
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product->name;
        
        if ($this->options && !empty($this->options)) {
            $optionStrings = [];
            foreach ($this->options as $key => $value) {
                $optionStrings[] = ucfirst($key) . ': ' . $value;
            }
            $name .= ' (' . implode(', ', $optionStrings) . ')';
        }
        
        return $name;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CartItemFactory
    {
        return CartItemFactory::new();
    }
}