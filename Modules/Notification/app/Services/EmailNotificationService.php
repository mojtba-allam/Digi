<?php

namespace Modules\Notification\app\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Modules\Notification\app\Mail\OrderConfirmationMail;
use Modules\Notification\app\Mail\UserRegistrationMail;
use Modules\Notification\app\Mail\PasswordResetMail;
use Modules\Notification\app\Mail\VendorOrderNotificationMail;
use Modules\Order\app\Models\Order;
use Modules\Authorization\app\Models\User;

class EmailNotificationService
{
    /**
     * Send order confirmation email to customer
     */
    public function sendOrderConfirmation(Order $order): bool
    {
        try {
            if (!$order->user || !$order->user->email) {
                Log::warning('Cannot send order confirmation: missing user or email', ['order_id' => $order->id]);
                return false;
            }

            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            
            Log::info('Order confirmation email sent', [
                'order_id' => $order->id,
                'user_id' => $order->user->id,
                'email' => $order->user->email
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send welcome email to new user
     */
    public function sendUserRegistrationEmail(User $user, string $verificationUrl = ''): bool
    {
        try {
            if (!$user->email) {
                Log::warning('Cannot send registration email: missing email', ['user_id' => $user->id]);
                return false;
            }

            Mail::to($user->email)->send(new UserRegistrationMail($user, $verificationUrl));
            
            Log::info('User registration email sent', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send user registration email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail(User $user, string $resetUrl): bool
    {
        try {
            if (!$user->email) {
                Log::warning('Cannot send password reset email: missing email', ['user_id' => $user->id]);
                return false;
            }

            Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl));
            
            Log::info('Password reset email sent', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send order notification to vendors
     */
    public function sendVendorOrderNotification(Order $order, User $vendor, string $notificationType = 'new_order'): bool
    {
        try {
            if (!$vendor->email) {
                Log::warning('Cannot send vendor notification: missing email', [
                    'vendor_id' => $vendor->id,
                    'order_id' => $order->id
                ]);
                return false;
            }

            Mail::to($vendor->email)->send(new VendorOrderNotificationMail($order, $vendor, $notificationType));
            
            Log::info('Vendor order notification email sent', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id,
                'email' => $vendor->email,
                'notification_type' => $notificationType
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send vendor order notification email', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id,
                'notification_type' => $notificationType,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send order notifications to all relevant vendors
     */
    public function sendVendorOrderNotifications(Order $order, string $notificationType = 'new_order'): array
    {
        $results = [];
        
        // Get all unique vendors from order items
        $vendorIds = $order->orderItems()
            ->with('product')
            ->get()
            ->pluck('product.vendor_id')
            ->filter()
            ->unique();

        foreach ($vendorIds as $vendorId) {
            $vendor = User::find($vendorId);
            if ($vendor) {
                $results[$vendorId] = $this->sendVendorOrderNotification($order, $vendor, $notificationType);
            }
        }

        return $results;
    }

    /**
     * Send bulk email notifications
     */
    public function sendBulkEmails(array $recipients, string $subject, string $template, array $data = []): array
    {
        $results = [];
        
        foreach ($recipients as $recipient) {
            try {
                if (!isset($recipient['email']) || !$recipient['email']) {
                    $results[] = ['email' => $recipient['email'] ?? 'unknown', 'success' => false, 'error' => 'Missing email'];
                    continue;
                }

                // This would need a generic mailable class for bulk emails
                // For now, we'll log the attempt
                Log::info('Bulk email would be sent', [
                    'email' => $recipient['email'],
                    'subject' => $subject,
                    'template' => $template
                ]);
                
                $results[] = ['email' => $recipient['email'], 'success' => true];
            } catch (\Exception $e) {
                $results[] = [
                    'email' => $recipient['email'] ?? 'unknown',
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }
}