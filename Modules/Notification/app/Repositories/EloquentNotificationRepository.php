<?php
namespace Modules\Notification\app\Repositories;

use Modules\Notification\app\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentNotificationRepository implements NotificationRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Notification::paginate($perPage);
    }

    public function find(int $id): Notification
    {
        return Notification::findOrFail($id);
    }

    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    public function update(Notification $notification, array $data): Notification
    {
        $notification->update($data);
        return $notification;
    }

    public function delete(Notification $notification): bool
    {
        return (bool) $notification->delete();
    }
}
