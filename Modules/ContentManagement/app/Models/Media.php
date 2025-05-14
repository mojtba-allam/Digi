<?php

namespace Modules\ContentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ContentManagement\Database\Factories\MediaFactory;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['type', 'url'];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    // protected static function newFactory(): MediaFactory
    // {
    //     // return MediaFactory::new();
    // }
}
