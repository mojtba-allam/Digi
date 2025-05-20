<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\database\factories\OrderStatusFactory;

// use Modules\Order\Database\Factories\OrderStatuFactory;

class OrderStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_id', 'status'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected static function newFactory(): OrderStatusFactory
    {
        return OrderStatusFactory::new();
    }
}
