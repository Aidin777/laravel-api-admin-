<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCompleteRoundEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $duel;
    public $firstUser;
    public $secondUser;
    
    public function __construct($duel)
    {
        $this->duel = $duel;
        $this->firstUser = $duel->duelContestants[0]->user;
        $this->secondUser = $duel->duelContestants[1]->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new Channel('duelCompletion_'.$this->firstUser->id),
            new Channel('duelCompletion_'.$this->secondUser->id),
        ];
    }

    public function broadcastAs()
    {
        return 'duel.user.completeRound';
    }

    public function broadcastWith(): array
    {
        return [
            'duel-progress' => $this->duel->completed_users,
        ];
    }
}
