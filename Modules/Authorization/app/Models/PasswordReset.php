<?php

namespace Modules\Authorization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authorization\database\factories\PasswordResetFactory;

class PasswordReset extends Model
{
    use HasFactory;
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): PasswordResetFactory
    {
        return PasswordResetFactory::new();
    }
}
