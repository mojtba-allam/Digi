<?php

namespace Modules\SearchAndFiltering\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\SearchAndFiltering\Database\Factories\SearchLogFactory;

class SearchLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'query',
        'user_id',
    ];

    /**
     * Get the user that owns the search log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // protected static function newFactory(): SearchLogFactory
    // {
    //     // return SearchLogFactory::new();
    // }
}
