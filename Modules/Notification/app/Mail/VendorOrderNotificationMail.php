<?php

namespace Modules\Notification\app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Order\app\Models\Order;
use Modules\Authorization\app\Models\User;

class VendorOrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public User $vendor;
    public string $notificationType;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, User $vendor, string $notificationType = 'new_order')
    {
        $this->order = $order;
        $this->vendor = $vendor;
        $this->notificationType = $notificationType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->notificationType) {
            'new_order' => 'New Order Received - Order #' . $this->order->id,
            'order_cancelled' => 'Order Cancelled - Order #' . $this->order->id,
            'payment_received' => 'Payment Received - Order #' . $this->order->id,
            default => 'Order Update - Order #' . $this->order->id,
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notification::emails.vendor-order-notification',
            with: [
                'order' => $this->order,
                'vendor' => $this->vendor,
                'notificationType' => $this->notificationType,
                'items' => $this->order->orderItems,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}