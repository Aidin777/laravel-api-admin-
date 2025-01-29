<?php

namespace App\Listeners;

use App\Events\DuelCompletionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DuelWinnerListener
{


    /**
     * Handle the event.
     */
    public function handle(DuelCompletionEvent $event): void
    {
        if($event->firstContestant->isCounted && $event->secondContestant->isCounted) {
            return;
        }

        $event->firstContestant->update(['isCounted' => true]);
        $event->secondContestant->update(['isCounted' => true]);

        if ($event->firstContestant->nominal_score > $event->secondContestant->nominal_score) {
            $event->duel->update(['winner_id' => $event->firstContestant->user_id]);

            $event->firstContestant->user->duel_wins += 1;
            $event->secondContestant->user->duel_loses += 1;

            $event->secondContestant->user->save();
            $event->firstContestant->user->save();
            return;

        } else if ($event->firstContestant->nominal_score < $event->secondContestant->nominal_score) {
            $event->duel->update(['winner_id' => $event->secondContestant->user_id]);

            $event->secondContestant->user->duel_wins += 1;
            $event->firstContestant->user->duel_loses += 1;

            $event->secondContestant->user->save();
            $event->firstContestant->user->save();
            return;
        } else {
            $event->secondContestant->user->duel_draws += 1;
            $event->firstContestant->user->duel_draws += 1;
        }


        $event->secondContestant->user->save();
        $event->firstContestant->user->save();
    }
}
