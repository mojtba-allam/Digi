<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Authorization\Models\User;

// use Modules\User\Database\Factories\ProfileFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['avatar', 'bio', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
