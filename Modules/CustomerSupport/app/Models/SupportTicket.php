<?php

namespace Modules\CustomerSupport\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\app\Models\User;

class SupportTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'subject',
        'message',
        'status',
        'history',
        'user_id',
    ];

    /**
     * Get the user that owns the support ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // protected static function newFactory(): SupportTicketFactory
    // {
    //     // return SupportTicketFactory::new();
    // }
}
