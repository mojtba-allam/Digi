<?php

namespace Modules\Authorization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Authorization\Database\Factories\PasswordResetFactory;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'token',
    ];
    // protected static function newFactory(): PasswordResetFactory
    // {
    //     // return PasswordResetFactory::new();
    // }
}
