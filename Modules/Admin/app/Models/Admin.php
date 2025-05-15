<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Authorization\app\Models\TemporaryPermission;
use Modules\Authorization\app\Models\Role;
// use Modules\Admin\Database\Factories\AdminFactory;

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

}
