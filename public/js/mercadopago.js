// mercadopago.js

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
