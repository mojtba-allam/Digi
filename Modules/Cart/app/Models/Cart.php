<?php

namespace Modules\Cart\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\app\Models\User;
use Modules\Cart\database\factories\CartFactory;
use Modules\PromotionAndCoupon\app\Models\Coupon;
use Modules\Product\app\Models\Product;

class Cart extends Model
{
    use HasFactory;
    
    protected $table = 'cart';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'status'
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the coupons applied to the cart.
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'cart_coupons');
    }

    /**
     * Get the products in the cart (legacy relationship).
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_items')
                    ->withPivot('quantity', 'price', 'options')
                    ->withTimestamps();
    }

    /**
     * Get the total number of items in the cart.
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Get the subtotal of the cart.
     */
    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * Get the total discount amount from coupons.
     */
    public function getDiscountAttribute(): float
    {
        $discount = 0;
        $subtotal = $this->subtotal;

        foreach ($this->coupons as $coupon) {
            if ($coupon->type === 'percentage') {
                $discount += ($subtotal * $coupon->value / 100);
            } elseif ($coupon->type === 'fixed') {
                $discount += $coupon->value;
            }
        }

        return min($discount, $subtotal); // Discount cannot exceed subtotal
    }

    /**
     * Get the total amount of the cart.
     */
    public function getTotalAttribute(): float
    {
        return max(0, $this->subtotal - $this->discount);
    }

    /**
     * Check if the cart is empty.
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Add a product to the cart.
     */
    public function addItem(Product $product, int $quantity = 1, array $options = [], ?int $productVariantId = null): CartItem
    {
        // Check if item already exists with same options
        $existingItem = $this->items()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $productVariantId)
            ->where('options', json_encode($options))
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem->fresh();
        }

        // Create new cart item
        return $this->items()->create([
            'product_id' => $product->id,
            'product_variant_id' => $productVariantId,
            'quantity' => $quantity,
            'price' => $product->price, // You might want to get variant price if applicable
            'options' => $options,
        ]);
    }

    /**
     * Update item quantity in the cart.
     */
    public function updateItem(int $itemId, int $quantity): bool
    {
        $item = $this->items()->find($itemId);
        
        if (!$item) {
            return false;
        }

        if ($quantity <= 0) {
            return $this->removeItem($itemId);
        }

        $item->update(['quantity' => $quantity]);
        return true;
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(int $itemId): bool
    {
        return $this->items()->where('id', $itemId)->delete() > 0;
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(): bool
    {
        return $this->items()->delete() > 0;
    }

    /**
     * Apply a coupon to the cart.
     */
    public function applyCoupon(Coupon $coupon): bool
    {
        if ($this->coupons()->where('coupon_id', $coupon->id)->exists()) {
            return false; // Coupon already applied
        }

        $this->coupons()->attach($coupon->id);
        return true;
    }

    /**
     * Remove a coupon from the cart.
     */
    public function removeCoupon(Coupon $coupon): bool
    {
        return $this->coupons()->detach($coupon->id) > 0;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }
}
