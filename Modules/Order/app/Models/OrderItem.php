<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\database\factories\OrderItemFactory;
use Modules\Product\app\Models\Product;


// use Modules\Order\Database\Factories\OrderItemFactory;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_id', 'quantity', 'price', 'order_id', 'order_id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function return_requests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    protected static function newFactory(): OrderItemFactory
    {
        return OrderItemFactory::new();
    }
}
