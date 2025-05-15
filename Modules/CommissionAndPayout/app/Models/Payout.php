<?php

namespace Modules\CommissionAndPayout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Business\Models\Vendor;

// use Modules\CommissionAndPayout\Database\Factories\PayoutFactory;

class Payout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['amount', 'vendor_id', 'status'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // protected static function newFactory(): PayoutFactory
    // {
    //     // return PayoutFactory::new();
    // }
}
