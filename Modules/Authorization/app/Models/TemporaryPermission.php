<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\app\Models\Admin;
use Modules\Authorization\database\factories\TemporaryPermissionFactory;

class TemporaryPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['admin_id', 'permission_id', 'expires_at'];

    public function admin():BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function permission():BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    protected static function newFactory(): TemporaryPermissionFactory
    {
        return TemporaryPermissionFactory::new();
    }
}




