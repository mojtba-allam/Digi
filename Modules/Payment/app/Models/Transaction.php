<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Payment\Database\Factories\TransactionsFactory;

class transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['transaction_ref', 'status', 'payment_id'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    // protected static function newFactory(): TransactionsFactory
    // {
    //     // return TransactionsFactory::new();
    // }
}
