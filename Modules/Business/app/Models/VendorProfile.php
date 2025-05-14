<?php

namespace Modules\Business\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Business\Database\Factories\VendorProfileFactory;

class VendorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_id',
        'description',
        'vendor_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
