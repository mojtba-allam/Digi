<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Cart\app\Models\Cart;
use Modules\List\app\Models\Wishlist;
use Modules\Order\app\Models\Order;
use Modules\Notification\app\Models\Notification;
use Modules\Business\app\Models\Vendor;
use Modules\Notification\app\Models\NotificationSubscription;
use Modules\SearchAndFiltering\app\Models\SearchLog;
use Modules\CustomerSupport\app\Models\SupportTicket;
use Modules\CustomerSupport\app\Models\Chat;
use Modules\User\app\Models\Address;
use Modules\User\app\Models\UserSetting;
use Modules\Reaction\app\Models\Review;
use Modules\Authorization\database\factories\UserFactory;

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

    public function notifications():HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function vendors():HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function notification_subscriptions():HasMany
    {
        return $this->hasMany(NotificationSubscription::class);
    }

    public function search_logs():HasMany
    {
        return $this->hasMany(SearchLog::class);
    }

    public function support_tickets():HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function chats():HasMany
    {
        return $this->hasMany(Chat::class);
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

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
