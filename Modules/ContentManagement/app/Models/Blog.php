<?php

namespace Modules\ContentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ContentManagement\database\factories\BlogFactory;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['media_id', 'title', 'slug', 'content'];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    protected static function newFactory(): BlogFactory
    {
        return BlogFactory::new();
    }
}
