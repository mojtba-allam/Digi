<?php

namespace Modules\Notification\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Notification\app\Services\EmailNotificationService;
use Modules\Order\app\Models\Order;
use Modules\Authorization\app\Models\User;
use Modules\Reaction\app\Traits\ApiResponse;

class EmailNotificationController extends Controller
{
    use ApiResponse;

    protected EmailNotificationService $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Send order confirmation email manually
     */
    public function sendOrderConfirmation(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::with(['user', 'orderItems.product'])->findOrFail($request->order_id);
        
        $success = $this->emailService->sendOrderConfirmation($order);

        if ($success) {
            return $this->successResponse(
                null,
                'Order confirmation email sent successfully',
                200
            );
        }

        return $this->errorResponse(
            'Failed to send order confirmation email',
            500
        );
    }

    /**
     * Send user registration email manually
     */
    public function sendUserRegistration(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'verification_url' => 'nullable|url'
        ]);

        $user = User::findOrFail($request->user_id);
        $verificationUrl = $request->verification_url ?? '';
        
        $success = $this->emailService->sendUserRegistrationEmail($user, $verificationUrl);

        if ($success) {
            return $this->successResponse(
                null,
                'User registration email sent successfully',
                200
            );
        }

        return $this->errorResponse(
            'Failed to send user registration email',
            500
        );
    }

    /**
     * Send password reset email manually
     */
    public function sendPasswordReset(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reset_url' => 'required|url'
        ]);

        $user = User::findOrFail($request->user_id);
        
        $success = $this->emailService->sendPasswordResetEmail($user, $request->reset_url);

        if ($success) {
            return $this->successResponse(
                null,
                'Password reset email sent successfully',
                200
            );
        }

        return $this->errorResponse(
            'Failed to send password reset email',
            500
        );
    }

    /**
     * Send vendor order notification manually
     */
    public function sendVendorOrderNotification(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'vendor_id' => 'required|exists:users,id',
            'notification_type' => 'required|in:new_order,order_cancelled,payment_received'
        ]);

        $order = Order::with(['user', 'orderItems.product'])->findOrFail($request->order_id);
        $vendor = User::findOrFail($request->vendor_id);
        
        $success = $this->emailService->sendVendorOrderNotification(
            $order, 
            $vendor, 
            $request->notification_type
        );

        if ($success) {
            return $this->successResponse(
                null,
                'Vendor order notification email sent successfully',
                200
            );
        }

        return $this->errorResponse(
            'Failed to send vendor order notification email',
            500
        );
    }

    /**
     * Send bulk emails
     */
    public function sendBulkEmails(Request $request): JsonResponse
    {
        $request->validate([
            'recipients' => 'required|array',
            'recipients.*.email' => 'required|email',
            'recipients.*.name' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'template' => 'required|string',
            'data' => 'nullable|array'
        ]);

        $results = $this->emailService->sendBulkEmails(
            $request->recipients,
            $request->subject,
            $request->template,
            $request->data ?? []
        );

        $successCount = collect($results)->where('success', true)->count();
        $totalCount = count($results);

        return $this->successResponse(
            [
                'results' => $results,
                'summary' => [
                    'total' => $totalCount,
                    'successful' => $successCount,
                    'failed' => $totalCount - $successCount
                ]
            ],
            "Bulk email operation completed. {$successCount}/{$totalCount} emails sent successfully",
            200
        );
    }

    /**
     * Test email configuration
     */
    public function testEmailConfiguration(Request $request): JsonResponse
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            // Create a test user for email testing
            $testUser = new User([
                'name' => 'Test User',
                'email' => $request->test_email
            ]);

            $success = $this->emailService->sendUserRegistrationEmail($testUser, url('/test-verification'));

            if ($success) {
                return $this->successResponse(
                    null,
                    'Test email sent successfully to ' . $request->test_email,
                    200
                );
            }

            return $this->errorResponse(
                'Failed to send test email',
                500
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Email configuration test failed: ' . $e->getMessage(),
                500
            );
        }
    }
}