<?php

namespace App\Http\Controllers;

use App\Traits\ErrorLogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    use ErrorLogTrait;
    protected $client;
    

    public function __construct()
    {
        $PAYPAL_CLIENT_ID = env('PAYPAL_CLIENT_ID');
        $PAYPAL_SECRET = env('PAYPAL_SECRET');

        $this->client = PaypalServerSdkClientBuilder::init()
            ->clientCredentialsAuthCredentials(
                ClientCredentialsAuthCredentialsBuilder::init(
                    $PAYPAL_CLIENT_ID,
                    $PAYPAL_SECRET
                )
            )
            ->environment(Environment::SANDBOX)
            ->build();
            
        
    }

    /**
     * Crear una orden de pago en PayPal.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request)
    {
        $data = $request->input('cart');  // Suponemos que recibimos el carrito con la información del producto

        $purchaseUnits = [];

        foreach ($data as $item) {
            $purchaseUnits[] = PurchaseUnitRequestBuilder::init(
                AmountWithBreakdownBuilder::init("USD", $item['price'] * $item['quantity'])
                    ->build()
            )->build();
        }

        $orderBody = [
            "intent" => "CAPTURE", // Aseguramos que el 'intent' sea 'CAPTURE' para poder capturar el pago.
            "purchase_units" => $purchaseUnits
        ];

        try {
            // Realizamos la llamada a la API de PayPal para crear la orden
            $apiResponse = $this->client->getOrdersController()->ordersCreate($orderBody);

            // Procesamos la respuesta de PayPal
            $jsonResponse = json_decode($apiResponse->getBody(), true);

            // Si la respuesta contiene el 'id' de la orden, lo regresamos al cliente
            return response()->json([
                'orderID' => $jsonResponse['id'],
                'status' => $jsonResponse['status']
            ]);
        } catch (\Exception $e) {
            // Mejor manejo de errores con más detalles
            return response()->json([
                'error' => $e->getMessage(),
                'errorDetails' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Capturar el pago de una orden de PayPal.
     *
     * @param string $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function capturePayment($orderId)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        // Preparamos el cuerpo de la solicitud de captura con el ID de la orden
        $captureBody = [
            "payer_id" => request()->input('payer_id'), // El payer_id se debe pasar desde el frontend
        ];

        $apiResponse = $this->client->getOrdersController()->ordersCapture([
            'orderId' => $orderId, // El ID de la orden
            'captureBody' => $captureBody // El cuerpo de la solicitud para captura
        ]);


        try {
            // Realizamos la llamada a la API de PayPal para capturar el pago
            $apiResponse = $this->client->getOrdersController()->ordersCapture([
                'orderId' => $orderId, // El ID de la orden
                'captureBody' => $captureBody // El cuerpo de la solicitud para captura
            ]);

            
            // Procesamos la respuesta de PayPal
            $jsonResponse = json_decode($apiResponse->getBody(), true);

            // Retornamos el resultado al cliente
            return response()->json([
                'status' => $jsonResponse['status'],
                'details' => $jsonResponse
            ]);
        } catch (\Exception $e) {
            ErrorLogTrait::logError("paymentlog","error en PaypalController@capturePayment",$e);
            // Mejor manejo de errores con más detalles
            return response()->json([
                'error' => $e->getMessage(),
                'errorDetails' => $e->getTraceAsString()
            ], 500);
        }
    }
}
