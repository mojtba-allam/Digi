<?php

namespace Modules\Notification\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Map the module's routes.
     */
    public function map(): void
    {
        // Load API routes: /api/...
        Route::prefix('api')
            ->middleware('api')
            ->group(module_path('Notification', 'routes/api.php'));

        // (Optional) Load web routes if you have them:
        Route::middleware('web')
            ->group(module_path('Notification', 'routes/web.php'));
    }
}