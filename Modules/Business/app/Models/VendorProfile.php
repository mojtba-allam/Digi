<?php

namespace Modules\Business\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Business\database\factories\VendorProfileFactory;

class VendorProfile extends Model
{
    use HasFactory;

    protected $table = 'vendor_profile';

    protected $fillable = [
        'tax_id',
        'description',
        'vendor_id',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    protected static function newFactory(): VendorProfileFactory
    {
        return VendorProfileFactory::new();
    }
}
