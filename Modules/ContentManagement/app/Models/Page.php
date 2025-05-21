<?php

namespace Modules\ContentManagement\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ContentManagement\database\factories\PageFactory;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'body', 'media_id'];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }
}
