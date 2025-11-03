<?php

namespace Modules\Notification\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Authorization\app\Models\User;

class PasswordResetRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public string $resetUrl;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
    }
}