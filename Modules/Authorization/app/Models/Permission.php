<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Authorization\app\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\app\Models\TemporaryPermission;
use Modules\Authorization\database\factories\PermissionFactory;

// use Modules\Authorization\database\factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = ['name', 'id'];

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function temporary_permissions():HasMany
    {
        return $this->hasMany(TemporaryPermission::class);
    }

    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
}
