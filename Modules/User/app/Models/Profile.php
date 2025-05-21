<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\app\Models\User;
use Modules\User\database\factories\ProfileFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['avatar', 'bio', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): ProfileFactory
    {
        return ProfileFactory::new();
    }
}
