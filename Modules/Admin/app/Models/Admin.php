<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Authorization\app\Models\TemporaryPermission;
use Modules\Authorization\app\Models\Role;
use Modules\Admin\database\factories\AdminFactory;
use Modules\CustomerSupport\app\Models\Chat;
use Modules\Authorization\app\Models\OAuth;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function temporary_permissions(): HasMany
    {
        return $this->hasMany(TemporaryPermission::class);
    }
    public function chats():MorphMany
    {
        return $this->morphMany(Chat::class,'sender');
    }

    public function oAuths(): MorphMany
    {
        return $this->morphMany(OAuth::class, 'authenticatable');
    }

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }

}
