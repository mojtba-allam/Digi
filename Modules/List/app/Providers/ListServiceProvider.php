<?php

namespace Modules\List\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\List\app\Repositories\WishlistRepositoryInterface;
use Modules\List\app\Repositories\EloquentWishlistRepository;
use Modules\List\app\Repositories\WishlistItemRepositoryInterface;
use Modules\List\app\Repositories\EloquentWishlistItemRepository;

class ListServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            WishlistRepositoryInterface::class,
            EloquentWishlistRepository::class
        );
        $this->app->bind(
            WishlistItemRepositoryInterface::class,
            EloquentWishlistItemRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(
            module_path('List', 'Resources/lang'),
            'list'
        );
    }
}