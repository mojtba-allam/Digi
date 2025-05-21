<?php

namespace Modules\List\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(module_path('List', 'routes/api.php'));

        Route::middleware('web')
            ->group(module_path('List', 'routes/web.php'));
    }
}