@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/mercadopago.js', 'resources/js/paypal.js'])

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id=AV_t2GwrkU3GNHT-2j3ecZ7NR_OuNSf6b95LTu4hYvnVbhj8bDwsisudEVzUMbwb61xK8m7dN2uIcBs2&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
    data-sdk-integration-source="developer-studio"></script>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Contenedor con el Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
                    @forelse ($packages_types as $package) 
                    <div class="p-6 rounded-lg" onclick="openModal({{$package->id}},'Plan de canciones: {{$package->songs_limit}} tema/s', {{$package->price}})">
                        <img class="cursor-pointer"  src="{{ asset("imagenes/plan$package->id.png") }}" alt="Plan 1">
                    </div>
                    @empty
                        <div>No hay Paquetes Disponibles</div>
                    @endforelse
                    

                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Opciones de Pago -->
    <div class="py-12">
        <div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-white rounded-lg p-8 w-1/3">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Selecciona un método de pago</h3>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Tarjeta Mercado Pago -->
                    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                        <h4 class="text-lg font-semibold text-gray-800">Mercado Pago</h4>
                        <p class="mt-4 text-gray-600">Paga con Mercado Pago de forma rápida y segura.</p>
                        <div class="mt-6">
                            <button id="checkout-btn"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">Seleccionar
                                Mercado Pago</button>
                        </div>
                    </div>

                    <!-- Tarjeta PayPal -->
                    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                        <h4 class="text-lg font-semibold text-gray-800">PayPal</h4>
                        <p class="mt-4 text-gray-600">Paga con tu cuenta de PayPal.</p>
                        <div id="paypal-button-container" class="mt-4"></div>
                        <p id="result-message"></p>
                    </div>
                </div>

                <div class="mt-6">
                    <button onclick="closeModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 w-full">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>