<?php

namespace Modules\ContentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\app\Models\ProductMedia;

// use Modules\ContentManagement\Database\Factories\MediaFactory;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['type', 'url'];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function product_medias(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    // protected static function newFactory(): MediaFactory
    // {
    //     // return MediaFactory::new();
    // }
}
