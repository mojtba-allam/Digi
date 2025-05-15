<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Order\Database\Factories\OrderInvoiceFactory;

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

    // protected static function newFactory(): OrderInvoiceFactory
    // {
    //     // return OrderInvoiceFactory::new();
    // }
}
