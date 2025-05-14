<?php

namespace Modules\SearchAndFiltering\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SearchAndFiltering\Database\Factories\FilterFactory;

class Filter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type',
        'value',
    ];

    // protected static function newFactory(): FilterFactory
    // {
    //     // return FilterFactory::new();
    // }
}
