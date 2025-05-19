<?php

namespace Modules\Notification\app\Http\Controllers;

use Modules\Notification\app\Http\Requests\StoreNotificationRequest;
use Modules\Notification\app\Http\Requests\UpdateNotificationRequest;
use Modules\Notification\app\Http\Resources\NotificationResource;
use Modules\Notification\app\Repositories\NotificationRepositoryInterface;
use App\Http\Controllers\Controller;
use Modules\Notification\app\Models\Notification;
use Illuminate\Http\Request;
use Modules\Reaction\app\Traits\ApiResponse;

class NotificationController extends Controller
{
    use ApiResponse;

    protected NotificationRepositoryInterface $notifications;

    public function __construct(NotificationRepositoryInterface $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $this->notifications
            ->paginate((int)$request->input('per_page', 10));
        return NotificationResource::collection($page);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notification::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        $notification = $this->notifications->create($request->validated());

        return $this->successResponse(
            new NotificationResource($notification),
            __('notification::messages.notification.created'),
            201
        );
    }

    /**
     * Show the specified resource.
     */
    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('notification::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $this->notifications->update($notification, $request->validated());

        return $this->successResponse(
            __('notification::messages.notification.updated'),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $this->notifications->delete($notification);

        return $this->successResponse(
            __('notification::messages.notification.deleted'),
            200
        );
    }
}
