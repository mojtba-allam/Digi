<?php

namespace Modules\Notification\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type',
        'subject',
        'body'
    ];

    protected static function newFactory()
    {
        return \Modules\Notification\database\factories\NotificationTemplateFactory::new();
    }
}
