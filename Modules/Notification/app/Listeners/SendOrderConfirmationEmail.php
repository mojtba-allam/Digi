<?php

namespace Modules\Notification\app\Listeners;

use Modules\Notification\app\Events\OrderCreated;
use Modules\Notification\app\Services\EmailNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderConfirmationEmail implements ShouldQueue
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
    public function handle(OrderCreated $event): void
    {
        // Send confirmation email to customer
        $this->emailService->sendOrderConfirmation($event->order);
        
        // Send notification emails to vendors
        $this->emailService->sendVendorOrderNotifications($event->order, 'new_order');
    }
}