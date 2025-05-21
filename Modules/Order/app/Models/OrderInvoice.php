<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\database\factories\OrderInvoiceFactory;

// use Modules\Order\database\factories\OrderInvoiceFactory;

class OrderInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_id', 'invoice_file'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected static function newFactory(): OrderInvoiceFactory
    {
        return OrderInvoiceFactory::new();
    }
}
