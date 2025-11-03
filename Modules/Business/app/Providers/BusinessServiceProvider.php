<?php

namespace Modules\Business\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Modules\Business\App\Http\Middleware\VendorMiddleware;

class BusinessServiceProvider extends ServiceProvider
{
    public function register() {}
    
    public function boot()
    {
        $this->registerMiddleware();
    }
    
    /**
     * Register middleware.
     */
    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('vendor', VendorMiddleware::class);
    }
}