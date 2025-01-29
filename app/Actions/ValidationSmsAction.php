<?php
namespace App\Actions;
use GreenSMS\GreenSMS;
class ValidationSmsAction {
    public function handle($unveriedfUser)
    {
        $message = "Код подтверждения: {$unveriedfUser->code}";
        $client = new GreenSMS([
            'user' => env('GREENSMS_CLIENT'),
            'pass' => env("GREENSMS_PASSWORD")
          ]);

        $response = $client->sms->send([
            'to' => $unveriedfUser->phone,
            'txt' => $message,
            // 'from' => 'EgeWay'
        ]);
        return $response;
    }
}
