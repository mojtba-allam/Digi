<?php

namespace Modules\SearchAndFiltering\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\SearchAndFiltering\database\factories\FilterFactory::new();
    }
}
