<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DuelCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $duel;
    public $firstUser;
    public $secondUser;

    public function __construct($duel, $firstUser, $secondUser)
    {
        $this->duel = $duel;
        $this->firstUser = $firstUser;
        $this->secondUser = $secondUser;
    }

    public function broadcastOn()
    {
        return [
            new Channel('duels_'. $this->firstUser->id),
            new Channel('duels_'. $this->secondUser->id),
        ];
    }

    public function broadcastAs()
    {
        return 'duel.created';
    }

    public function broadcastWith(): array
    {
        return [
            'duel' => $this->duel,
            'firstUser' => $this->firstUser,
            'secondUser' => $this->secondUser
        ];
    }
}
