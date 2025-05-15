<?php

namespace Modules\CommissionAndPayout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Business\Models\Vendor;
use Modules\Order\Models\Order;

// use Modules\CommissionAndPayout\Database\Factories\CommissionFactory;

class Commission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['vendor_id', 'order_id', 'rate'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // protected static function newFactory(): CommissionFactory
    // {
    //     // return CommissionFactory::new();
    // }
}
