<?php

namespace Modules\Notification\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Notification\app\Repositories\NotificationRepositoryInterface;
use Modules\Notification\app\Repositories\EloquentNotificationRepository;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            NotificationRepositoryInterface::class,
            EloquentNotificationRepository::class
        );
    }

    public function boot(): void
    {
        // Load translations
        $this->loadTranslationsFrom(
            module_path('Notification', 'Resources/lang'),
            'notification'
        );
    }
}
