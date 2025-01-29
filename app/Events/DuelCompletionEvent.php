<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DuelCompletionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $duel;
    public $firstContestant;
    public $secondContestant;
    /**
     * Create a new event instance.
     */

    public function __construct($duel, $contestants)
    {
        $this->duel = $duel;
        $this->firstContestant= $contestants[0];
        $this->secondContestant= $contestants[1];
    }



}
