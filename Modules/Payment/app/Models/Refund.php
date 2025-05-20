<?php

namespace Modules\Payment\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Payment\database\factories\RefundFactory;

// use Modules\Payment\Database\Factories\RefundsFactory;

class Refund extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['amount', 'reason', 'payment_id'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    protected static function newFactory(): RefundFactory
    {
        return RefundFactory::new();
    }
}
