<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <!-- MENSAJES DE ESTADO DE PAGO -->
    @if (session('success'))
        <div class="py-12">
            <div id="success-message"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center duration-300"
                role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="py-12">
            <div id="error-message"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center duration-200"
                role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Contenedor con el Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
                    @forelse ($packages_types as $package)
                    <div class="p-6 rounded-lg" onclick="openModal('Plan de canciones: {{$package->songs_limits}} tema/s', {{$package->price}},{{$package->id}})">
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
                        <div class="mt-6">
                            <button
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Seleccionar
                                PayPal</button>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button onclick="closeModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 w-full">Cerrar</button>
                </div>
            </div>
        </div>

        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script >
            window.openModal = function (planName, planPrice, idPack) {
    window.selectedPlan = {
        name: planName,
        price: planPrice,
        idPackage: idPack,
    };
    document.getElementById('paymentModal').classList.remove('hidden');
};

window.closeModal = function () {
    document.getElementById('paymentModal').classList.add('hidden');
};

// Inicializar Mercado Pago
const mp = new MercadoPago('{{$publicKey}}');

// Evento para el botón de checkout
document.getElementById('checkout-btn').addEventListener('click', function () {
    // Crear el objeto 'orderData' solo con el plan seleccionado
    const orderData = {
        product: [
            {
                title: window.selectedPlan.name,
                description: 'Descripción del producto', // HAY QUE AGREGAR DESCRIPCION DEL PRODUCTO
                currency_id: "ARS",
                quantity: 1,
                id_pack: window.selectedPlan.idPackage,
                unit_price: window.selectedPlan.price,
            },
        ],
    };

    console.log('Datos del pedido:', orderData);

    const createPreferenceUrl = "{{ route('mercadopago.createPreference') }}";

    // Solicitud al servidor para crear una preferencia de pago
    fetch(createPreferenceUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: JSON.stringify(orderData),
    })
        .then(response => response.json())
        .then(preference => {
            if (preference.error) {
                throw new Error(preference.error);
            }

            // Redirigir al usuario a la URL de pago
            window.location.href = preference.init_point;
        })
        .catch(error => console.error('Error al crear la preferencia:', error));
});

        </script>

    </div>


</x-app-layout>