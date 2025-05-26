<?php

namespace Modules\Business\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Authorization\app\Models\User;
use Modules\CommissionAndPayout\app\Models\Commission;
use Modules\CommissionAndPayout\app\Models\Payout;
use Modules\CommissionAndPayout\app\Models\Settlement;
use Modules\Product\app\Models\Product;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\ReturnRequest;
use Modules\Business\database\factories\VendorFactory;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'company_name',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function vendor_profile() : HasOne
    {
        return $this->hasOne(VendorProfile::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }
    public function vendor_commissions(): HasMany
    {
        return $this->hasMany(VendorCommission::class);
    }
    public function return_requests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }
    public function settlements() : HasMany
    {
        return $this->hasMany(Settlement::class);
    }
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    protected static function newFactory(): VendorFactory
    {
        return VendorFactory::new();
    }
}
