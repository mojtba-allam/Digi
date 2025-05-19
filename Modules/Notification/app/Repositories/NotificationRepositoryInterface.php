<?php
namespace Modules\Notification\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Notification\app\Models\Notification;

interface NotificationRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): Notification;
    public function create(array $data): Notification;
    public function update(Notification $notification, array $data): Notification;
    public function delete(Notification $notification): bool;
}
