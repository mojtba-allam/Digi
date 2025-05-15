<?php

namespace Modules\Payment\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\app\Models\Order;
use Modules\Payment\app\Models\Transaction;
// use Modules\Payment\Database\Factories\PaymentsFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_id', 'amount', 'status'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // protected static function newFactory(): PaymentsFactory
    // {
    //     // return PaymentsFactory::new();
    // }
}
