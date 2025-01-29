<?php

namespace App\Listeners;

use App\Events\DuelCompletionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DuelWinningListener
{


    /**
     * Handle the event.
     */
    public function handle(DuelCompletionEvent $event): void
    {
        $event->duel->update(['status' => 'complete']);
        $event->firstContestant->user->update(['inDuel'=> false]);
        $event->secondContestant->user->update(['inDuel'=> false]);
    }
}
