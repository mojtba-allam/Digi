<?php

namespace Modules\Notification\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
// use Modules\Notification\Database\Factories\NotificationFactory;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'body',
        'read_at',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    // protected static function newFactory(): NotificationFactory
    // {
    //     // return NotificationFactory::new();
    // }

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
