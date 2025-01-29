<?php
namespace App\Actions;
use App\Events\DuelCreatedEvent;
use App\Models\Duel;
use App\Models\DuelContestant;
use App\Models\DuelQuestion;
use App\Models\DuelQueue;
use App\Models\Question;
class CreateDuel {
    public function handle()
    {
        $duel = Duel::create(['status' => 'pending', 'winner_id' => null]);

        $firstUser = DuelQueue::first()->user;
        $secondUser = DuelQueue::skip(1)->first()->user;

        $Firstcontestant = DuelContestant::create([
            'user_id' => $firstUser->id,
            'duel_id' => $duel->id
        ]);
        $Secondcontestant = DuelContestant::create([
            'user_id' => $secondUser->id,
            'duel_id' => $duel->id
        ]);

        if($Secondcontestant->user_id === $Firstcontestant->user_id)
        {
            $Firstcontestant->delete();
            $duel->delete();
            return false;
        };

        $firstUser->update(['inDuel' => true]);
        $secondUser->update(['inDuel' => true]);

        // Add random questions
        $questionIds = Question::inRandomOrder()->limit(7)->pluck('id');

        foreach ($questionIds as $questionId) {
            DuelQuestion::create([
                'duel_id' => $duel->id,
                'question_id' => $questionId
            ]);
        }



        // Fire event
        broadcast(new DuelCreatedEvent($duel, $firstUser, $secondUser));

        // Remove users from queue
        DuelQueue::whereIn('user_id', [$firstUser->id, $secondUser->id])->delete();
        return true;
    }

}
