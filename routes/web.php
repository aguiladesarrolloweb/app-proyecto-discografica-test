<?php

use App\Http\Controllers\MercadoPagoController;
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
        return view('dashboard');
    })->name('dashboard');

     /* ROTES MODULES CARPETA */
     foreach (glob(__DIR__ . '/modules/*.php') as $routeFile) {
        require_once $routeFile;
    }

    // RUTAS DE MERCADO PAGO
    Route::post('/create-preference', [MercadoPagoController::class, 'createPaymentPreference']);
    Route::get('/mercadopago/success', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
    Route::get('/mercadopago/failed', [MercadoPagoController::class, 'failed'])->name('mercadopago.failed');
});
