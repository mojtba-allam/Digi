<?php

namespace Modules\AnalyticsAndReporting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AnalyticsAndReporting\Database\Factories\ReportFactory;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'body',
        'exported_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // protected static function newFactory(): ReportFactory
    // {
    //     // return ReportFactory::new();
    // }
}
