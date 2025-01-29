<?php

namespace App\Http\Controllers;

use App\Actions\CreateDuel;
use App\Models\DuelQueue;
use Illuminate\Http\Request;
use App\Models\Duel;
use App\Models\DuelContestant;
use App\Events\DuelCreatedEvent;

class DuelSessionController extends Controller
{
    public function append(Request $request, CreateDuel $duelFactory) : void
    {
        $user = $request->user();
        DuelQueue::create(['user_id' => $user->id]);
        $user->update(['inQueu' => true]);

        if (DuelQueue::count() >= 2) {
            $response = $duelFactory->handle();
            if($response){
                $user->update(['inQueu' => false]);
            }
        }

    }
    public function returnToDuel(Request $request)
    {
        $user = $request->user();
        $duel = DuelContestant::where('user_id', $user->id)->duel;
        if($duel =='completed')
        {
            $user->update(['inDuel' => false]);
            return $user;
        }
        return $duel;
    }


    public function queueLeave(Request $request)
    {
        DuelQueue::where('user_id', $request->user()->id)->delete();
    }
}
