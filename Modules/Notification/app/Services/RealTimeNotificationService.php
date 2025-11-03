<?php

namespace Modules\Notification\app\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;
use Modules\Notification\app\Models\Notification;
use Modules\Notification\app\Models\NotificationPreference;
use Modules\Authorization\app\Models\User;

class RealTimeNotificationService
{
    /**
     * Create and send a real-time notification
     */
    public function sendNotification(
        User $user,
        string $title,
        string $body,
        string $type = 'general',
        array $data = [],
        string $actionUrl = null,
        string $priority = 'medium'
    ): ?Notification {
        try {
            // Check user preferences for this notification type
            $preference = NotificationPreference::where('user_id', $user->id)
                ->where('notification_type', $type)
                ->first();

            // If user has disabled in-app notifications for this type, skip
            if ($preference && !$preference->isInAppEnabled()) {
                Log::info('In-app notification skipped due to user preferences', [
                    'user_id' => $user->id,
                    'type' => $type
                ]);
                return null;
            }

            // Create the notification
            $notification = Notification::create([
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body,
                'type' => $type,
                'data' => $data,
                'action_url' => $actionUrl,
                'priority' => $priority,
            ]);

            // Broadcast the notification in real-time
            $this->broadcastNotification($notification);

            Log::info('Real-time notification sent', [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'type' => $type
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to send real-time notification', [
                'user_id' => $user->id,
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send notification to multiple users
     */
    public function sendBulkNotifications(
        array $userIds,
        string $title,
        string $body,
        string $type = 'general',
        array $data = [],
        string $actionUrl = null,
        string $priority = 'medium'
    ): array {
        $results = [];
        
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $notification = $this->sendNotification(
                    $user, $title, $body, $type, $data, $actionUrl, $priority
                );
                $results[$userId] = $notification ? $notification->id : null;
            }
        }

        return $results;
    }

    /**
     * Send order status update notification
     */
    public function sendOrderStatusUpdate(User $user, $order, string $newStatus): ?Notification
    {
        $title = 'Order Status Updated';
        $body = "Your order #{$order->id} status has been updated to: " . ucfirst($newStatus);
        
        return $this->sendNotification(
            $user,
            $title,
            $body,
            'order_update',
            [
                'order_id' => $order->id,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $newStatus,
            ],
            url("/orders/{$order->id}"),
            'high'
        );
    }

    /**
     * Send vendor order notification
     */
    public function sendVendorOrderNotification(User $vendor, $order, string $notificationType): ?Notification
    {
        $titles = [
            'new_order' => 'New Order Received',
            'order_cancelled' => 'Order Cancelled',
            'payment_received' => 'Payment Received',
        ];

        $bodies = [
            'new_order' => "You have received a new order #{$order->id}",
            'order_cancelled' => "Order #{$order->id} has been cancelled",
            'payment_received' => "Payment received for order #{$order->id}",
        ];

        $title = $titles[$notificationType] ?? 'Order Update';
        $body = $bodies[$notificationType] ?? "Order #{$order->id} has been updated";

        return $this->sendNotification(
            $vendor,
            $title,
            $body,
            'vendor_order',
            [
                'order_id' => $order->id,
                'notification_type' => $notificationType,
                'customer_name' => $order->user->name ?? 'Unknown',
            ],
            url("/vendor/orders/{$order->id}"),
            'high'
        );
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        try {
            $notification = Notification::where('id', $notificationId)
                ->where('user_id', $userId)
                ->first();

            if (!$notification) {
                return false;
            }

            return $notification->markAsRead();
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read', [
                'notification_id' => $notificationId,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(int $userId): bool
    {
        try {
            Notification::where('user_id', $userId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get unread notification count for user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->unread()
            ->count();
    }

    /**
     * Get recent notifications for user
     */
    public function getRecentNotifications(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Delete old notifications
     */
    public function cleanupOldNotifications(int $daysOld = 30): int
    {
        $cutoffDate = now()->subDays($daysOld);
        
        return Notification::where('created_at', '<', $cutoffDate)
            ->whereNotNull('read_at') // Only delete read notifications
            ->delete();
    }

    /**
     * Broadcast notification to user's channel
     */
    protected function broadcastNotification(Notification $notification): void
    {
        try {
            // This would typically use Laravel Echo/Pusher for real-time broadcasting
            // For now, we'll log the broadcast attempt
            Log::info('Broadcasting notification', [
                'notification_id' => $notification->id,
                'user_id' => $notification->user_id,
                'channel' => "user.{$notification->user_id}",
                'event' => 'notification.created'
            ]);

            // In a real implementation, you would do:
            // broadcast(new NotificationCreated($notification))->toOthers();
        } catch (\Exception $e) {
            Log::error('Failed to broadcast notification', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}