<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Business\Models\Vendor;
use Modules\Product\Models\ProductVariants;

// use Modules\Order\Database\Factories\ReturnRequestFactory;

class ReturnRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_item_id', 'product_variant_id', 'reason', 'status', 'history', 'vendor_id'];

    public function order_item(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product_variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariants::class);
    }

    // protected static function newFactory(): ReturnRequestFactory
    // {
    //     // return ReturnRequestFactory::new();
    // }
}
