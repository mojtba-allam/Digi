<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Cart\app\Models\Cart;
use Modules\List\app\Models\Wishlist;
use Modules\Order\app\Models\Order;
use Modules\Notification\app\Models\Notification;
use Modules\Business\app\Models\Vendor;
use Modules\CustomerSupport\app\Models\Chat;
use Modules\User\app\Models\Address;
use Modules\User\app\Models\Profile;
use Modules\User\app\Models\UserSetting;
use Modules\Reaction\app\Models\Review;
use Modules\Authorization\database\factories\UserFactory;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory;
    use Notifiable;

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

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
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

    public function notifications():HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function vendors():HasMany
    {
        return $this->hasMany(Vendor::class);
    }
    public function chats():MorphMany
    {
        return $this->morphMany(Chat::class,'sender');
    }

    public function addresses():HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function user_settings():HasMany
    {
        return $this->hasMany(UserSetting::class);
    }

    public function vendor():HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function profile() : HasOne
    {
        return $this->hasOne(Profile::class);
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function oAuths(): MorphMany
    {
        return $this->morphMany(OAuth::class, 'authenticatable');
    }

}
