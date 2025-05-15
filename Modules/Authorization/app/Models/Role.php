<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\app\Models\Admin;
use Modules\Authorization\app\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\app\Models\TemporaryPermission;
// use Modules\Authorization\Database\Factories\RoleFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name','id'];

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
}
