<?php

use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $publicKey = config('services.mercadopago.public_key');
        $packages_types = PackageType::all();
        return view('dashboard',compact('publicKey',"packages_types"));
    })->name('dashboard');
    

     /* ROTES MODULES CARPETA */
     foreach (glob(__DIR__ . '/modules/*.php') as $routeFile) {
        require_once $routeFile;
    }

    Route::post('lang/change', function (Request $request) {
        $lang = $request->lang;
    
        if (in_array($lang, ['es', 'en', 'pt'])) {
            session(['locale' => $lang]);
            App::setLocale($lang);
        }
    
        return redirect()->back();
    })->name('lang.change');


    // RUTAS DE STRIPE
    Route::post('/create-preference-stripe', [StripeController::class, 'createPaymentPreference'])->name('stripe.createPreference');
    Route::get('/success-stripe', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/failed-stripe', [StripeController::class, 'failed'])->name('stripe.failed');


    Route::get('/stripe', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
    Route::post('/test', 'App\Http\Controllers\StripeController@test');
    Route::post('/live', 'App\Http\Controllers\StripeController@live');
    Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');

    // RUTAS DE PAYPAL
    Route::get('/paypal', [PaypalController::class, 'index'])->name('paypal.index');
    Route::get('/paypal/create/{amount}', [PaypalController::class, 'create'])->name('paypal.create');
    Route::post('/paypal/complete', [PaypalController::class, 'complete'])->name('paypal.complete');

    // RUTAS DE MERCADO PAGO
    Route::post('/create-preference-mercadopago', [MercadoPagoController::class, 'createPaymentPreference'])->name('mercadopago.createPreference');
    Route::get('/success-mercadopago', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
    Route::get('/failed-mercadopago', [MercadoPagoController::class, 'failed'])->name('mercadopago.failed');
});
