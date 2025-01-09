


@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id=AV_t2GwrkU3GNHT-2j3ecZ7NR_OuNSf6b95LTu4hYvnVbhj8bDwsisudEVzUMbwb61xK8m7dN2uIcBs2&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
    data-sdk-integration-source="developer-studio"></script>

    <x-app-layout>
        <x-slot name="header">
            <!--
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Immersound') }}
            </h2> -->
        </x-slot>
    
    
        <div class="py-24 bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('imagenes/fondo_dashboard.png') }}');">
            <!-- Capa de opacidad -->
            <div class="absolute inset-0 bg-black opacity-75"></div>
            
            <!-- Contenido (con posición relativa para que aparezca sobre la capa de opacidad) -->
            <div class="relative max-w-4xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-center text-4xl font-bold text-white whitespace-nowrap">{{__("dashboard.mezcla")}}</h2>
    
                <p class="text-center text-white text-sm mt-4">Mezcla y masteriza tu música en Audio Espacial de forma accesible y destaca en las plataformas<br>
                con una calidad de sonido excepcional.</p>

                <div class="overflow-hidden sm:rounded-lg mt-16">
                    <!-- Contenedor con el Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
    
                @forelse ($packages_types as $package) 
                        <div class="p-6 rounded-lg" onclick="openModal({{$package->id}},'Plan de canciones: {{$package->songs_limit}} tema/s', {{$package->price}})">
                            <img class="cursor-pointer"  src="{{ asset("imagenes/plan$package->id.png") }}" alt="Plan {{$package->id}}">
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
                <div class="bg-white rounded-lg p-6 pt-3 w-3/4 max-w-4xl min-h-[400px]">
                    <h3 class="text-2xl font-semibold text-white mb-4 mt-4 text-center font-montserrat">Métodos de pagos disponibles</h3>
    
                    <div class="grid grid-cols-3 gap-8 mt-4">
                        <!-- Mercado Pago -->
                        <div class="bg-gray-100 p-5 pt-2 rounded-lg shadow-lg flex flex-col h-[350px]">
                            <div class="flex-grow mb-4">
                                <img src="{{ asset('imagenes/mercado_pago_modal.png') }}" alt="Mercado Pago" class="w-24 h-24 object-contain mx-auto mb-2">
                                <p class="mt-4 text-sm text-gray-600">Paga con Mercado Pago de forma rápida y segura.</p>
                                {{-- <p class="mt-6 text-base font-medium text-white price-text text-center">Accede a tu paquete en Dolby Atmos por solo $219.</p> --}}
                            </div>
                            <div class="mb-6 flex justify-center">
                                <button id="checkout-btn"
                                    class="bg-[#FF0A93] text-white hover:text-[#C49CBC] active:text-[#FF0A93] px-6 py-2 rounded-md hover:bg-[#d4087c] transition duration-200">
                                    Pagar</button>
                            </div>
                        </div>
    
                        <!-- PayPal -->
                        {{-- <div class="bg-gray-100 p-5 rounded-lg shadow-lg flex flex-col h-[350px]">
                            <div class="mb-4">
                                <img src="{{ asset('imagenes/paypal_modal.png') }}" alt="PayPal" class="w-24 h-24 object-contain mx-auto mb-2">
                                <p class="mt-4 text-sm text-gray-600">Paga con PayPal de forma rápida y segura.</p>
                                <p class="mt-6 text-base font-medium text-white price-text text-center">Accede a tu paquete en Dolby Atmos por solo $219.</p>
                            </div>
                            <div class="mt-auto mb-4 flex justify-center">
                                <button
                                    class="bg-[#FF0A93] text-white hover:text-[#C49CBC] active:text-[#FF0A93] px-6 py-2 rounded-md hover:bg-[#d4087c] transition duration-200">
                                    Pagar</button>
                            </div>
                        </div> --}}
    
                        <!-- Stripe -->
                        <div class="bg-gray-100 p-5 rounded-lg shadow-lg flex flex-col h-[350px]">
                            <div class="mb-4">
                                <img src="{{ asset('imagenes/stripe_modal.png') }}" alt="Stripe" class="w-24 h-24 object-contain mx-auto mb-2">
                                <p class="mt-4 text-sm text-gray-600">Paga con Stripe de forma rápida y segura.</p>
                            </div>
                            <div class="mt-auto mb-4 flex justify-center">
                                <button id="checkout-btn-stripe"
                                    class="bg-[#FF0A93] text-white hover:text-[#C49CBC] active:text-[#FF0A93] px-6 py-2 rounded-md hover:bg-[#d4087c] transition duration-200">
                                    Pagar</button>
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-12">
                        <button onclick="closeModal()"
                            class="bg-[#FF0A93] text-white hover:text-[#C49CBC] active:text-[#FF0A93] px-3 py-1.5 rounded-md hover:bg-[#d4087c] transition duration-200 w-full">
                            Cerrar</button>
                    </div>
                </div>
            </div>
    
        </div>
    
    
    </x-app-layout>