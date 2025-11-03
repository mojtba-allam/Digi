<?php

namespace Modules\Notification\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Notification\app\Services\RealTimeNotificationService;
use Modules\Notification\app\Models\Notification;
use Modules\Notification\app\Models\NotificationPreference;
use Modules\Authorization\app\Models\User;
use Modules\Reaction\app\Traits\ApiResponse;

class RealTimeNotificationController extends Controller
{
    use ApiResponse;

    protected RealTimeNotificationService $notificationService;

    public function __construct(RealTimeNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get user's notifications
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = $request->input('per_page', 15);
        $type = $request->input('type');
        $unreadOnly = $request->boolean('unread_only', false);

        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($type) {
            $query->ofType($type);
        }

        if ($unreadOnly) {
            $query->unread();
        }

        $notifications = $query->paginate($perPage);

        return $this->successResponse($notifications, 'Notifications retrieved successfully');
    }

    /**
     * Get unread notification count
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $user = $request->user();
        $count = $this->notificationService->getUnreadCount($user->id);

        return $this->successResponse(['count' => $count], 'Unread count retrieved successfully');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, int $notificationId): JsonResponse
    {
        $user = $request->user();
        $success = $this->notificationService->markAsRead($notificationId, $user->id);

        if ($success) {
            return $this->successResponse(null, 'Notification marked as read');
        }

        return $this->errorResponse('Failed to mark notification as read', 400);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $success = $this->notificationService->markAllAsRead($user->id);

        if ($success) {
            return $this->successResponse(null, 'All notifications marked as read');
        }

        return $this->errorResponse('Failed to mark all notifications as read', 400);
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, int $notificationId): JsonResponse
    {
        $user = $request->user();
        
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return $this->errorResponse('Notification not found', 404);
        }

        $notification->delete();

        return $this->successResponse(null, 'Notification deleted successfully');
    }

    /**
     * Send notification (admin only)
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'nullable|string|max:50',
            'data' => 'nullable|array',
            'action_url' => 'nullable|url',
            'priority' => 'nullable|in:low,medium,high'
        ]);

        $user = User::findOrFail($request->user_id);
        
        $notification = $this->notificationService->sendNotification(
            $user,
            $request->title,
            $request->body,
            $request->type ?? 'general',
            $request->data ?? [],
            $request->action_url,
            $request->priority ?? 'medium'
        );

        if ($notification) {
            return $this->successResponse($notification, 'Notification sent successfully', 201);
        }

        return $this->errorResponse('Failed to send notification', 500);
    }

    /**
     * Send bulk notifications (admin only)
     */
    public function sendBulk(Request $request): JsonResponse
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'nullable|string|max:50',
            'data' => 'nullable|array',
            'action_url' => 'nullable|url',
            'priority' => 'nullable|in:low,medium,high'
        ]);

        $results = $this->notificationService->sendBulkNotifications(
            $request->user_ids,
            $request->title,
            $request->body,
            $request->type ?? 'general',
            $request->data ?? [],
            $request->action_url,
            $request->priority ?? 'medium'
        );

        $successCount = count(array_filter($results));
        $totalCount = count($results);

        return $this->successResponse([
            'results' => $results,
            'summary' => [
                'total' => $totalCount,
                'successful' => $successCount,
                'failed' => $totalCount - $successCount
            ]
        ], "Bulk notifications sent. {$successCount}/{$totalCount} successful");
    }

    /**
     * Get user's notification preferences
     */
    public function getPreferences(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $preferences = NotificationPreference::where('user_id', $user->id)->get();

        return $this->successResponse($preferences, 'Notification preferences retrieved successfully');
    }

    /**
     * Update user's notification preferences
     */
    public function updatePreferences(Request $request): JsonResponse
    {
        $request->validate([
            'preferences' => 'required|array',
            'preferences.*.notification_type' => 'required|string',
            'preferences.*.email_enabled' => 'boolean',
            'preferences.*.push_enabled' => 'boolean',
            'preferences.*.in_app_enabled' => 'boolean',
            'preferences.*.frequency' => 'in:immediate,daily,weekly,never'
        ]);

        $user = $request->user();
        $updatedPreferences = [];

        foreach ($request->preferences as $preferenceData) {
            $preference = NotificationPreference::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type' => $preferenceData['notification_type']
                ],
                [
                    'email_enabled' => $preferenceData['email_enabled'] ?? true,
                    'push_enabled' => $preferenceData['push_enabled'] ?? true,
                    'in_app_enabled' => $preferenceData['in_app_enabled'] ?? true,
                    'frequency' => $preferenceData['frequency'] ?? 'immediate'
                ]
            );

            $updatedPreferences[] = $preference;
        }

        return $this->successResponse($updatedPreferences, 'Notification preferences updated successfully');
    }

    /**
     * Get recent notifications for dashboard
     */
    public function recent(Request $request): JsonResponse
    {
        $user = $request->user();
        $limit = $request->input('limit', 5);

        $notifications = $this->notificationService->getRecentNotifications($user->id, $limit);

        return $this->successResponse($notifications, 'Recent notifications retrieved successfully');
    }
}