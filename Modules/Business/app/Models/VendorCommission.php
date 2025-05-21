<?php

namespace Modules\Business\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Business\database\factories\VendorCommissionFactory;

class VendorCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'vendor_id',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    protected static function newFactory(): VendorCommissionFactory
    {
        return VendorCommissionFactory::new();
    }
}
