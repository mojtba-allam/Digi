<?php

namespace Modules\CustomerSupport\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Authorization\app\Models\User;
use Modules\CustomerSupport\database\factories\ChatFactory;

class Chat extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message',
        'sent_at',
        'sender_id',
        'sender_type',
    ];

    /**
     * Get the user that owns the chat.
     */
    protected function sender():MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): ChatFactory
    {
        return ChatFactory::new();
    }
}
