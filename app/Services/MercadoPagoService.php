<?php
namespace App\Services;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
    }

    public function crearPreferencia($compra)
    {
        $client = new PreferenceClient();

$preference = $client->create([
"back_urls"=>array(
    "success" => "https://test.com/success",
    "failure" => "https://test.com/failure",
    "pending" => "https://test.com/pending"
),
/* "differential_pricing" => array(
    "id" => 1,
), */
"expires" => false,
"items" => array(
    array(
        "id" => "1234", // package->id
        "title" => "Dummy Title", // package->name
        "quantity" => 1,
        "currency_id" => "USD",
        "unit_price" => 2500
    )
),
"payer" => array(
    "name" => "Test",
    "surname" => "User",
    "email" => "your_test_email@example.com",
    "phone" => array(
        "area_code" => "11",
        "number" => "4444-4444"
    ),
    
),
/* "additional_info" => "Discount: 12.00", */
"auto_return" => "all",
"binary_mode" => true,
"external_reference" => "1643827245", // crear numeros al azar que no se repitan en la transaccion

/* "notification_url" => "https://notificationurl.com", */ // notificar la transaccion
/* "operation_type" => "regular_payment", */


]);

    }
}