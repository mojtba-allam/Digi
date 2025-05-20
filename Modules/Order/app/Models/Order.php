<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Business\app\Models\Vendor;
use Modules\CommissionAndPayout\app\Models\Commission;
use Modules\Order\database\factories\OrderFactory;
use Modules\Payment\app\Models\Payment;
use Modules\Authorization\app\Models\User;

// use Modules\Order\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'total_amount', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function order_status(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function order_invoices(): HasMany
    {
        return $this->hasMany(OrderInvoice::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
