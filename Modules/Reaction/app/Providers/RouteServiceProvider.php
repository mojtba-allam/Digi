<?php

namespace Modules\Reaction\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Map the module's routes.
     */
    public function map(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(module_path('Reaction', 'routes/api.php'));

        Route::middleware('web')
            ->group(module_path('Reaction', 'routes/web.php'));
    }
}
