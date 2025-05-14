<?php

namespace Modules\Authorization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Models\Admin;

// use Modules\Authorization\Database\Factories\TemporaryPermissionFactory;

class TemporaryPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['admin_id', 'permission_id', 'expires_at'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}




