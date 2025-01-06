<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaypalController extends Controller
{
    /**
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function index()
    {
        return view('paypal.index');
    }

    /**
     * @return string
     */
    private function getAccessToken(): string
    {
        $headers = [
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode(config('services.paypal.paypal_id') . ':' . config('paypal.paypal_secret'))
        ];

        $response = Http::withHeaders($headers)
                        ->withBody('grant_type=client_credentials')
                        ->post(config('services.paypal.base_url') . '/v1/oauth2/token');

        return json_decode($response->body())->access_token;
    }

    /**
     * @return string
     */
    public function create(int $amount = 10): string
    {
        $id = Str::uuid();

        $headers = [
            'Content-Type'      => 'application/json',
            'Authorization'     => 'Bearer ' . $this->getAccessToken(),
            'PayPal-Request-Id' => $id,
        ];

        $body = [
            "intent"         => "CAPTURE",
            "purchase_units" => [
                [
                
                    "amount"       => [
                        "currency_code" => "USD",
                        "value"         => number_format($amount, 2),
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders($headers)
                        ->withBody(json_encode($body))
                        ->post(config('services.paypal.base_url'). '/v2/checkout/orders');

        Session::put('request_id', $id);
        Session::put('order_id', json_decode($response->body())->id);

        return json_decode($response->body())->id;
    }

    /**
     * @return mixed
     */
    public function complete(Request $request)
    {
        $orderID = $request->input('orderID');
        $paymentDetails = $request->input('paymentDetails');

         $client = new Client();
        $response = $client->request('GET', "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}");

        return json_decode($response->getBody(), true);
    }
}