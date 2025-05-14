<?php

namespace Modules\List\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\List\Database\Factories\WishlistItemFactory;

class WishlistItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'wishlist_id',
    ];

    /**
     * Get the wishlist that owns the item.
     */
    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    // protected static function newFactory(): WishlistItemFactory
    // {
    //     // return WishlistItemFactory::new();
    // }
}
