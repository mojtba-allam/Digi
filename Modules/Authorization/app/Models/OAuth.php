<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Authorization\database\factories\OAuthFactory;

class OAuth extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'provider_id',
        'provider_name',
        'user_id',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): OAuthFactory
    {
        return OAuthFactory::new();
    }
    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }
}
