<?php

namespace Modules\AnalyticsAndReporting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AnalyticsAndReporting\Database\Factories\AnalyticFactory;

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

    // protected static function newFactory(): AnalyticFactory
    // {
    //     // return AnalyticFactory::new();
    // }
}
