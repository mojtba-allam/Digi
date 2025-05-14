<?php

namespace Modules\CustomerSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\CustomerSupport\Database\Factories\FaqFactory;

class Faq extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question',
        'answer',
    ];

    // protected static function newFactory(): FaqFactory
    // {
    //     // return FaqFactory::new();
    // }
}
