<?php

namespace App\Http\Controllers;

use App\Models\PackageType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripeController extends Controller
{
    public $package_id = NULL;
    /**
     * @return View|Factory|Application
     */
    public function checkout(): View|Factory|Application
    {
        return view('checkout');
    }

    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */
    public function createPaymentPreference(Request $request)
    {
        $this->package_id = $request->product[0]['id_pack'];

        $package_selected = PackageType::find($this->package_id);
        // Paso 1: Obtener la información del producto desde la solicitud JSON
        $product = $request->input('product'); // Aquí esperamos recibir un array con los datos del producto

        $request->session()->put('package_id', $this->package_id);
        $request->session()->put('product', $product);


        Stripe::setApiKey(config('app.env') === 'production' 
        ? config('stripe.live.sk') 
        : config('stripe.test.sk'));

        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $request->product[0]['title'],
                        ],
                        'unit_amount'  => (int) $package_selected->unit_price * 100,
                    ],
                    'quantity'   => (int) 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url'  => route('dashboard'),
        ]);

        return response()->json(['url' => $session->url])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');

    }



    /**
     * @return View|Factory|Application
     */
    public function success(): View|Factory|Application
    {
        $package_id = session()->get('package_id');
        session()->forget('package_id');
        return view('payment.auto-submit', [
            'package_id' => $package_id
        ]);
    }
}