<?php

namespace Modules\Notification\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Authorization\app\Models\User;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public string $verificationUrl;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $verificationUrl = '')
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }
}