<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Notification\Database\Factories\NotificationTemplateFactory;

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

    // protected static function newFactory(): NotificationTemplateFactory
    // {
    //     // return NotificationTemplateFactory::new();
    // }
}
