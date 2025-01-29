<?php

namespace App\Http\Middleware;

use App\Models\PremiumOrder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckPayments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = $request->user();
            if($user){
                $order = PremiumOrder::where(['user_id'=> $user->id, 'status' => 'pending'])->first();
                $id = '1'.$order->id;
                
                if($order){
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
                }
            }
            return $next($request);
        } catch (\Throwable $th) {
            return $next($request);
        }
    }
}
