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

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'discount_amount',
        'shipping_amount',
        'tax_amount',
        'total_amount',
        'currency',
        'billing_address',
        'shipping_address',
        'notes',
        'shipped_at',
        'delivered_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order items (legacy relationship name).
     */
    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the commissions for the order.
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Get the order statuses for the order.
     */
    public function orderStatuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    /**
     * Get the order statuses (legacy relationship name).
     */
    public function order_status(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    /**
     * Get the order invoices for the order.
     */
    public function orderInvoices(): HasMany
    {
        return $this->hasMany(OrderInvoice::class);
    }

    /**
     * Get the order invoices (legacy relationship name).
     */
    public function order_invoices(): HasMany
    {
        return $this->hasMany(OrderInvoice::class);
    }

    /**
     * Get the vendors associated with the order.
     */
    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'vendor_order');
    }

    /**
     * Get the return requests for the order.
     */
    public function returnRequests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    /**
     * Check if the order can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    /**
     * Check if the order can be returned.
     */
    public function canBeReturned(): bool
    {
        return $this->status === 'delivered' && 
               $this->delivered_at && 
               $this->delivered_at->diffInDays(now()) <= 30;
    }

    /**
     * Get the order status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'processing' => 'indigo',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get the formatted order number.
     */
    public function getFormattedOrderNumberAttribute(): string
    {
        return $this->order_number ?: '#' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the billing address as a formatted string.
     */
    public function getFormattedBillingAddressAttribute(): string
    {
        if (!$this->billing_address) {
            return '';
        }

        $address = $this->billing_address;
        $lines = [
            $address['first_name'] . ' ' . $address['last_name'],
            $address['address_line_1'],
        ];

        if (!empty($address['address_line_2'])) {
            $lines[] = $address['address_line_2'];
        }

        $lines[] = $address['city'] . ', ' . $address['state'] . ' ' . $address['postal_code'];
        $lines[] = $address['country'];

        return implode("\n", $lines);
    }

    /**
     * Get the shipping address as a formatted string.
     */
    public function getFormattedShippingAddressAttribute(): string
    {
        if (!$this->shipping_address) {
            return '';
        }

        $address = $this->shipping_address;
        $lines = [
            $address['first_name'] . ' ' . $address['last_name'],
            $address['address_line_1'],
        ];

        if (!empty($address['address_line_2'])) {
            $lines[] = $address['address_line_2'];
        }

        $lines[] = $address['city'] . ', ' . $address['state'] . ' ' . $address['postal_code'];
        $lines[] = $address['country'];

        return implode("\n", $lines);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
