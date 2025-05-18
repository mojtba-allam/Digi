<?php

namespace Modules\Reaction\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewModeration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'review_id',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\Reaction\database\factories\ReviewModerationFactory::new();
    }

    /**
     * Get the review that owns the moderation.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
