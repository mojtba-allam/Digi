<?php

namespace Modules\Notification\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
// use Modules\Notification\Database\Factories\NotificationSubscriptionFactory;

class NotificationSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'channel',
        'status',
        'user_id'
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // protected static function newFactory(): NotificationSubscriptionFactory
    // {
    //     // return NotificationSubscriptionFactory::new();
    // }
}
