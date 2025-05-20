<?php

namespace Modules\PromotionAndCoupon\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\PromotionAndCoupon\database\factories\DiscountRuleFactory;

class DiscountRule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['promotion_id', 'condition_type', 'value'];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    protected static function newFactory(): DiscountRuleFactory
    {
        return DiscountRuleFactory::new();
    }
}
