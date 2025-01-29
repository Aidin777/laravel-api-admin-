<?php

namespace App\Http\Controllers;

use App\Events\DuelCompletionEvent;
use App\Events\UserCompleteRoundEvent;
use App\Http\Requests\DuelAnswerRequest;
use App\Models\Duel;
use App\Models\DuelContestant;
use Illuminate\Http\Request;

class DuelGameplayController extends Controller
{
    public function index($id, Request $request)
    {
        $duel = Duel::with([
            'duelContestants.user:id,name,avatar,duel_wins,duel_loses,duel_draws',
            'questions.question:id,theme,question,answers'])->findOrFail($id);

        return $duel;
    }

    public function contestantData(Request $request)
    {
        return DuelContestant::where('user_id', $request->user()->id)->orderByDesc('created_at')->firstOrFail();
    }

    public function makeAnswer(DuelAnswerRequest $request)
    {
        $request->validated($request->all());
        $user = DuelContestant::where('user_id', $request->user_id)->orderByDesc('created_at')->firstOrFail();

        if (!$user->scoreboard) {
            $user->scoreboard = [];
        }

        if(!$user->isComplete){
            $user->scoreboard += [$request->question_number => $request->isCorrect ];

            if($request->isCorrect) {
                $user->nominal_score += 1;
            }

            //making an check if its final question and complete session and make event, that broadcast it into duel chanel via sockets
            if($request->question_number == 7) {
                $user->update(['isComplete' => true]);
                $user->duel->completed_users += 1;
                $user->duel->save();
                event(new UserCompleteRoundEvent($user->duel));
            }
            $user->save();
        }
    }

    public function completeDuel(Request $request)
    {
        $duel = Duel::findOrFail($request->duel_id);
        if($duel->status !== 'completed') {
            $contestants = $duel->duelContestants;
            event(new DuelCompletionEvent($duel, $contestants));
        }

        return $duel;
    }

    public function test(Request $request)
    {
        // $user = DuelContestant::where('user_id', $request->user_id)->orderByDesc('created_at')->firstOrFail();
        // if($request->question_number == 7) {
        //     $user->isComplete = true;
        //     $user->duel->completed_users += 1;
        //     event(new UserCompleteRoundEvent($user->duel));
        //     $user->duel->save();
        // }
        dd(1);
    }
}
