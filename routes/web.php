<?php

use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PaypalController;
use App\Models\PackageType;
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

    

    // RUTAS DE PAYPAL
    Route::post('/api/orders', [PaypalController::class, 'createOrder']);
    Route::post('/api/orders/{orderId}/capture', [PaypalController::class, 'capturePayment']);

    // RUTAS DE MERCADO PAGO
    Route::post('/create-preference', [MercadoPagoController::class, 'createPaymentPreference'])->name('mercadopago.createPreference');
    Route::get('/mercadopago/success', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
    Route::get('/mercadopago/failed', [MercadoPagoController::class, 'failed'])->name('mercadopago.failed');
});
