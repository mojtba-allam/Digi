<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\app\Models\User;
use Modules\User\database\factories\UserSettingFactory;


class UserSetting extends Model
{
    use HasFactory;

    protected $casts = [
        'notifications_subscription' => 'array',
    ];

    protected $fillable = ['user_id', 'privacy_settings', 'notifications_enabled'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): UserSettingFactory
    {
        return UserSettingFactory::new();
    }
}
