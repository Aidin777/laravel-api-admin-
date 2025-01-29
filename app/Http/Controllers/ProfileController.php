<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileStoreRequest;
use App\Models\Promos;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HttpResponses;
    public function index(Request $request)
    {
        $user = $request->user();
        $promo = $user->promocode;

        return [
          'user' => $user,
          'promo' => $promo
        ];
    }

    public function store(ProfileStoreRequest $request)
    {
        $request->validated($request->all());
        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user = $request->user()->update($data);
        return $user;
    }
    public function verifyPromo(Request $request)
    {
        $promo = Promos::where('promocode', $request->promo)->firstOrFail();
        $user = $request->user();


        if($user->isPremium && !($user->approwed_promo)) {
            $user->approwed_promo = true;
            $user->save();
            $promo->update(['counter' => $promo->counter + 1]);
            return $this->success($promo, 'Промокод подтвержден');
        }
    }
}
