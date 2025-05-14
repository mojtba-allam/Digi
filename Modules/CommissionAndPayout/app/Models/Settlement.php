<?php

namespace Modules\CommissionAndPayout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vendor\app\Models\Vendor;

class Settlement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['month', 'amount', 'vendor_id', 'status'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // protected static function newFactory(): SettlementFactory
    // {
    //     // return SettlementFactory::new();
    // }
}
