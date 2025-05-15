<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\app\Models\OAuth;
use Modules\Cart\app\Models\Cart;
use Modules\Authorization\app\Models\PasswordReset;
use Modules\List\app\Models\Wishlist;
use Modules\Order\app\Models\Order;
// use Modules\Authorization\Database\Factories\UserFactory;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    public function oauth():HasMany
    {
        return $this->hasMany(OAuth::class);
    }

    public function carts():HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function password_resets():HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function wishlists():HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

}
