<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Exception;
use Illuminate\Support\Facades\Log;

class MercadoPagoController extends Controller
{
    public $package_id = NULL;

    public function createPaymentPreference(Request $request)
    {
        
        $this->package_id = $request->product[0]['id_pack'];
        Log::info('Creando preferencia de pago');
        $this->authenticate();
        Log::info('Autenticado con éxito');

        // Paso 1: Obtener la información del producto desde la solicitud JSON
        $product = $request->input('product'); // Aquí esperamos recibir un array con los datos del producto

        if (empty($product) || !is_array($product)) {
            return response()->json(['error' => 'Los datos del producto son requeridos.'], 400);
        }

        // Paso 2: Información del comprador
        // Aquí podrías personalizar la obtención de los datos del comprador, como el usuario autenticado
        $payer = [
            "name" => $request->input('payer_name', 'John'), // Se asume que los datos del usuario podrían venir del frontend o del usuario autenticado
            "surname" => $request->input('payer_surname', 'Doe'),
            "email" => $request->input('payer_email', 'user@example.com'),
        ];

        // Paso 3: Crear la solicitud de preferencia 
        $requestData = $this->createPreferenceRequest($product, $payer);

        // Paso 4: Crear la preferencia con el cliente de preferencia 
        $client = new PreferenceClient();

        try {
            $preference = $client->create($requestData);

            return response()->json([
                'id' => $preference->id,
                'init_point' => $preference->init_point, // Este es el enlace para redirigir al usuario al pago
            ]);
        } catch (MPApiException $error) {
            return response()->json([
                'error' => $error->getApiResponse()->getContent(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Autenticación con Mercado Pago 
    protected function authenticate()
    {
        $mpAccessToken = config('services.mercadopago.token');
        if (!$mpAccessToken) {
            throw new Exception("El token de acceso de Mercado Pago no está configurado.");
        }
        MercadoPagoConfig::setAccessToken($mpAccessToken);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    // Función para crear la estructura de preferencia 
    protected function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed')
        ];

        $request = [
            "items" => $items, // Los datos del producto que llegan del frontend
            "payer" => $payer, // Los datos del comprador
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "TIENDA ONLINE", // Puedes cambiar el texto que aparece en el estado de la tarjeta del comprador
            "external_reference" => "1234567890", // Puedes usar algún identificador único aquí
            "expires" => false,
            "auto_return" => 'approved', // Redirige automáticamente después de una aprobación
            "id_pack" =>  $this->package_id, // Redirige automáticamente después de una aprobación
        ];

        return $request;
    }

    public function success(Request $request)
    {
        // CAPTURAR LOS DATOS DE LA RESPUESTA DE MERCADO PAGO
        $paymentId = $request->query('payment_id');
        $status = $request->query('status');
        $merchantOrderId = $request->query('merchant_order_id');

        // VERIFICAR EL ESTADO DEL PAGO
        if ($status === 'approved') {
            return redirect(route('packages.create'))->with('success', 'Pago realizado con éxito. ID de pago: ' . $paymentId);
        }

      

        // En caso de otro estado, también podrías manejarlo
        return redirect('/dashboard')->with('error', 'El pago no se completó. Por favor, inténtalo de nuevo.');
    }
}
