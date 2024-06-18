<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class NewNotificationEvent
{
    use Dispatchable;

    public $user_id;
    public $message;

    public function __construct($user_id, $message)
    {
        $this->user_id = $user_id;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'link' => '/notifications/' . $this->user_id,
        ];
    }
}
