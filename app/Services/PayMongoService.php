<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
    }

    /**
     * Create a checkout session in PayMongo
     */
    public function createCheckoutSession($username, $useremail, $price)
    {
        //remove active session
        if (session()->has('paymongo_session_id')) {
            session()->forget('paymongo_session_id');
        }
        if (session()->has('order_id')) {
            session()->forget('order_id');
        }

        $url = "https://api.paymongo.com/v1/checkout_sessions";

        $data = [
            "data" => [
                "attributes" => [
                    "billing" => [
                        "name" => $username,
                        "email" => $useremail
                    ],
                    "send_email_receipt" => false,
                    "show_description" => true,
                    "show_line_items" => true,
                    "cancel_url" => url('/user/cart?cancel'),
                    "description" => "for reservation fee",
                    "line_items" => [
                        [
                            "currency" => "PHP",
                            "amount" => $price * 100, // Convert to cents
                            "description" => "reservation fees",
                            "name" => "service reserve",
                            "quantity" => 1
                        ]
                    ],
                    "payment_method_types" => ["gcash"],
                    "success_url" => url('/processpayment')
                ]
            ]
        ];

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Basic " . base64_encode($this->secretKey . ":")
        ])->post($url, $data);

        return $response->json();
    }

    /**
     * Retrieve payment ID using checkout session ID
     */
    public function getPaymentId($checkoutSessionId)
    {
        $url = "https://api.paymongo.com/v1/checkout_sessions/$checkoutSessionId";

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Basic " . base64_encode($this->secretKey . ":")
        ])->get($url);

        $data = $response->json();

        //payment id
        return $data['data']['attributes']['payments'][0]['id'] ?? null;
    }
}
