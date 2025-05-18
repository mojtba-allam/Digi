<?php

namespace Modules\AnalyticsAndReporting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'metric',
        'value',
        'created_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'analytics';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\AnalyticsAndReporting\database\factories\AnalyticFactory::new();
    }
}
