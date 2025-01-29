<?php
namespace App\Actions\Payments;
use Illuminate\Support\Facades\Http;




class PremiumPayment {
    public function handle(int $price, $order)
    {
        $id = '1'.$order->id;

        $url = 'https://pay.yandex.ru/api/merchant/v1/orders';
        try {
            $response = Http::accept('application/json')->withHeaders([
                'X-Request-Id' => uniqid(),
                'X-Request-Timeout' => '15000',
                'X-Request-Attempt' => '0',
                'Authorization' => 'Api-Key ' . env('YANDEX_MERCH_ID'),
            ])->post($url,[
                'availablePaymentMethods' => ['CARD'],
                'cart' => [
                    'externalId' => str($id),
                    'items' => [
                        [
                            'description' => 'Премиум подписка',
                            'productId' => str(1),
                            'quantity' => [
                                'available' => '999999',
                                'count' => '1',
                                'label' => 'шт'
                            ],
                            'title' => 'Премиум подписка',
                            'total' => $price,
                            'unitPrice' => $price
                        ]
                    ],
                    'total' => [
                        'amount' => $price,
                    ]
                ],
                'currencyCode' => 'RUB',
                'orderId' => str($id),
                'redirectUrls' => [
                    'onAbort'=> 'https://egeway.ru',
                    'onError'=> 'https://egeway.ru',
                    'onSuccess'=> env("APP_URL") . "/api/payments/premium/callback/$order->id"
                ],
                'orderSource' => 'WEBSITE',
                'preferredPaymentMethod' => 'FULLPAYMENT',
                'purpose' => 'Премиум подписка на приложение',
            ]
        );
            
            if($response->json()['status'] === 'fail'){
                $response = Http::withHeaders([
                    'X-Request-Id' => uniqid(),
                    'X-Request-Timeout' => '15000',
                    'X-Request-Attempt' => '0',
                    'Authorization' => 'Api-Key ' . env('YANDEX_MERCH_ID'),
                ])->get("https://pay.yandex.ru/api/merchant/v1/orders/$id");
                return $response->json()['data']['order']['paymentUrl'];
            };
            return $response->json()['data']['paymentUrl'];
        } catch (\Exception $e) {
            dd($e);
            $response = $e;
        }
    }
}
