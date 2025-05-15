<?php

namespace Modules\Authorization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Authorization\Database\Factories\OAuthFactory;

class OAuth extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'client_id',
        'client_secret',
        'redirect',
    ];
    // protected static function newFactory(): OAuthFactory
    // {
    //     // return OAuthFactory::new();
    // }
}
