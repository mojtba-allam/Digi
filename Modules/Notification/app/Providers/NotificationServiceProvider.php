<?php

namespace Modules\Notification\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Notification\app\Repositories\NotificationRepositoryInterface;
use Modules\Notification\app\Repositories\EloquentNotificationRepository;
use Modules\Notification\app\Services\EmailNotificationService;
use Modules\Notification\app\Events\OrderCreated;
use Modules\Notification\app\Events\UserRegistered;
use Modules\Notification\app\Events\PasswordResetRequested;
use Modules\Notification\app\Listeners\SendOrderConfirmationEmail;
use Modules\Notification\app\Listeners\SendUserRegistrationEmail;
use Modules\Notification\app\Listeners\SendPasswordResetEmail;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        OrderCreated::class => [
            SendOrderConfirmationEmail::class,
        ],
        UserRegistered::class => [
            SendUserRegistrationEmail::class,
        ],
        PasswordResetRequested::class => [
            SendPasswordResetEmail::class,
        ],
    ];

    public function register()
    {
        $this->app->bind(
            NotificationRepositoryInterface::class,
            EloquentNotificationRepository::class
        );

        // Register the email notification service
        $this->app->singleton(EmailNotificationService::class, function ($app) {
            return new EmailNotificationService();
        });
    }

    public function boot(): void
    {
        // Load translations
        $this->loadTranslationsFrom(
            module_path('Notification', 'Resources/lang'),
            'notification'
        );

        // Load views
        $this->loadViewsFrom(
            module_path('Notification', 'Resources/views'),
            'notification'
        );

        // Register event listeners
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
