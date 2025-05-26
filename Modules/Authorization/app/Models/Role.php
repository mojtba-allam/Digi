<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\app\Models\Admin;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\database\factories\RoleFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['role','id'];

    public function admins():HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function permissions():HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function temporary_permissions():HasMany
    {
        return $this->hasMany(TemporaryPermission::class);
    }

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
}
