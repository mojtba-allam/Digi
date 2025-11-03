<?php

namespace Modules\Notification\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\app\Models\User;

class NotificationPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'notification_type',
        'email_enabled',
        'push_enabled',
        'in_app_enabled',
        'frequency'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_enabled' => 'boolean',
        'push_enabled' => 'boolean',
        'in_app_enabled' => 'boolean',
    ];

    protected static function newFactory()
    {
        return \Modules\Notification\database\factories\NotificationPreferenceFactory::new();
    }

    /**
     * Get the user that owns the notification preference.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if email notifications are enabled for this type
     */
    public function isEmailEnabled(): bool
    {
        return $this->email_enabled;
    }

    /**
     * Check if push notifications are enabled for this type
     */
    public function isPushEnabled(): bool
    {
        return $this->push_enabled;
    }

    /**
     * Check if in-app notifications are enabled for this type
     */
    public function isInAppEnabled(): bool
    {
        return $this->in_app_enabled;
    }

    /**
     * Scope for specific notification type
     */
    public function scopeForType($query, string $type)
    {
        return $query->where('notification_type', $type);
    }

    /**
     * Scope for enabled email notifications
     */
    public function scopeEmailEnabled($query)
    {
        return $query->where('email_enabled', true);
    }

    /**
     * Scope for enabled push notifications
     */
    public function scopePushEnabled($query)
    {
        return $query->where('push_enabled', true);
    }

    /**
     * Scope for enabled in-app notifications
     */
    public function scopeInAppEnabled($query)
    {
        return $query->where('in_app_enabled', true);
    }
}