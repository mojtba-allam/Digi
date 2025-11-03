<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
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

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function temporaryPermissions(): HasMany
    {
        return $this->hasMany(TemporaryPermission::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        // Check direct permissions
        if ($this->permissions()->where('name', $permission)->exists()) {
            return true;
        }

        // Check role permissions
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }

    /**
     * Assign role to user
     */
    public function assignRole(string $role): void
    {
        $roleModel = Role::where('name', $role)->first();
        if ($roleModel && !$this->hasRole($role)) {
            $this->roles()->attach($roleModel->id);
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(string $role): void
    {
        $roleModel = Role::where('name', $role)->first();
        if ($roleModel) {
            $this->roles()->detach($roleModel->id);
        }
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is vendor
     */
    public function isVendor(): bool
    {
        return $this->hasRole('vendor');
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

}
