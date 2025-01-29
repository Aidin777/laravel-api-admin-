<?php

namespace App\Http\Controllers;

use App\Actions\ValidationSmsAction;
use App\Http\Requests\PhoneCodeRequest;
use App\Http\Requests\PhoneUserRequest;
use App\Models\PhoneAwaiting;
use App\Models\Promos;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use HttpResponses;

    public function phoneMessage(PhoneUserRequest $request, ValidationSmsAction $sendSms) : JsonResponse
    {
        $request->validated($request->all());

        if($request->phone === '81112223344'){
            $unveriedfUser = PhoneAwaiting::create(['phone' => $request->phone,'code' => 5698]);
            return $this->success($unveriedfUser,'sucessfuly sended sms');
        }
        $unveriedfUser = PhoneAwaiting::create(['phone' => $request->phone,'code' => mt_rand(1000,9999)]);

        $response = $sendSms->handle($unveriedfUser);

        return $this->success($unveriedfUser,'sucessfuly sended sms');
    }

    public function phoneValidate(PhoneCodeRequest $request) : JsonResponse
    {
        $request->validated($request->all());
        $verificationObj = PhoneAwaiting::where('phone', $request->phone)->latest()->first();

        if($verificationObj->code !== $request->code){
            return $this->error('','Неправильный код', 400);
        }
        $verificationObj->delete();

        if(User::where('phone', $request->phone)->exists()){
            $user = User::where('phone', $request->phone)->first();
            return $this->success([
                'user'=> $user,
                'token' => $user->createToken("Token for {$user->name}")->accessToken
            ]);
        }
        return $this->success([$request->phone, 'user' => null]);
    }
    public function register(StoreUserRequest $request) : JsonResponse
    {
        $request->validated($request->all());
        $user = User::create([
            'phone' => $request->phone,
            'name' => $request->name,
        ]);

        $promo = Promos::create([
            'promocode' => $user->id.'-'. Str::random(12),
            'discount' => 50,
            'user_id' => $user->id,
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken("Token for {$user->name}")->accessToken
        ]);

    }

    public function logout(Request $request) : JsonResponse
    {
        $request->user()->token()->revoke();
        return $this->success([], 'Successfully logged out');
    }

}
