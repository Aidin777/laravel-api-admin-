<?php

namespace App\Http\Controllers;

use App\Http\Requests\PremiumPayRequest;
use App\Models\PremiumOrder;
use App\Models\Promos;
use App\Models\User;
use App\Actions\Payments\PremiumPayment;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;

class PaymentController extends Controller
{
    use HttpResponses;
    public function premiumPayment(PremiumPayRequest $request, PremiumPayment $payment)
    {
        $request->validated($request->all());
        $user = User::where(['phone' => $request->phone, 'isPremium' => false])->firstOrFail();
        $order = PremiumOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($order && $order->created_at->diffInMinutes(now()) > 10) {
            $order->update(['status' => 'failed']);
            $order = PremiumOrder::create(['user_id' => $user->id, 'status' => 'pending']);
        } elseif (!$order) {
            $order = PremiumOrder::create(['user_id' => $user->id, 'status' => 'pending']);
        }

        $response = $payment->handle($request->price, $order);
        return response()->json(['redirect_url' => $response]);
    }

    public function premiumCallback(Request $request, $id)
    {
        $order = PremiumOrder::where(['id'=> $id, 'status' => 'pending'])->firstOrFail();
        $id = '1'.$order->id;
        
        $response = Http::withHeaders([
            'X-Request-Id' => uniqid(),
            'X-Request-Timeout' => '15000',
            'X-Request-Attempt' => '0',
            'Authorization' => 'Api-Key ' . env('YANDEX_MERCH_ID'),
        ])->get("https://pay.yandex.ru/api/merchant/v1/orders/$id");
        $status = $response->json()['data']['operations'][0]['status'];
        if($status === "SUCCESS"){
            $order->update(['status' => 'paid']);
                $order->user->isPremium = true;
                $order->user->save();
        };

        return redirect('https://egeway.ru');
    }

    public function checkPromo (Request $request)
    {
        $promo = Promos::where('promocode', $request->query('promocode'))->first();
        if($promo)
        {
            return $this->success(['discount' => $promo->discount]);
        }
        return $this->error([], 'Некоректный промокод',400);
    }
}
