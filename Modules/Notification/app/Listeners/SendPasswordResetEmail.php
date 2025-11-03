<?php

namespace Modules\Notification\app\Listeners;

use Modules\Notification\app\Events\PasswordResetRequested;
use Modules\Notification\app\Services\EmailNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordResetEmail implements ShouldQueue
{
    use InteractsWithQueue;

    protected EmailNotificationService $emailService;

    /**
     * Create the event listener.
     */
    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetRequested $event): void
    {
        $this->emailService->sendPasswordResetEmail($event->user, $event->resetUrl);
    }
}