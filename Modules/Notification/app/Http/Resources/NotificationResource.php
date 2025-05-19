<?php
namespace Modules\Notification\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'title'       => $this->title,
            'body'       => $this->body,
            'read_at'    => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
