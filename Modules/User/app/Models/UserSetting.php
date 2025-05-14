<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Authorization\Models\User;

// use Modules\User\Database\Factories\UserSettingFactory;


class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'privacy_settings', 'notifications_enabled'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
