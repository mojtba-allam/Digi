<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\database\factories\OrderItemFactory;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'total',
        'product_name',
        'product_sku',
        'product_options',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'product_options' => 'array',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant associated with the order item.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the product variant (legacy relationship name).
     */
    public function product_variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the return requests for the order item.
     */
    public function returnRequests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    /**
     * Get the return requests (legacy relationship name).
     */
    public function return_requests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    /**
     * Get the display name for the order item.
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product_name;
        
        if ($this->product_options && !empty($this->product_options)) {
            $optionStrings = [];
            foreach ($this->product_options as $key => $value) {
                $optionStrings[] = ucfirst($key) . ': ' . $value;
            }
            $name .= ' (' . implode(', ', $optionStrings) . ')';
        }
        
        return $name;
    }

    /**
     * Check if the item can be returned.
     */
    public function canBeReturned(): bool
    {
        return $this->order->canBeReturned() && 
               $this->returnRequests()->where('status', '!=', 'rejected')->doesntExist();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OrderItemFactory
    {
        return OrderItemFactory::new();
    }
}
