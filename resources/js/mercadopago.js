// Función para abrir el modal y establecer los valores del plan seleccionado
window.openModal = function (planId, planName, planPrice) {
    if (!planId || !planName || typeof planPrice !== 'number' || isNaN(planPrice)) {
        console.error('ID, nombre o precio del plan no especificado o inválido');
        return;
    }

    // Establecer el plan seleccionado en una variable global
    window.selectedPlan = {
        idPackage: planId, // El ID del plan (puede ser usado para PayPal)
        name: planName,
        price: planPrice
    };

    // Actualizar el contenido del modal (opcional)
    const modalNameElement = document.getElementById('modalPlanName');
    const modalPriceElement = document.getElementById('modalPlanPrice');
    if (modalNameElement) modalNameElement.textContent = planName;
    if (modalPriceElement) modalPriceElement.textContent = `$${planPrice.toFixed(2)}`;

    // Mostrar el modal
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.remove('hidden');
    } else {
        console.error('No se encontró el elemento con ID "paymentModal".');
    }
    console.log('Plan seleccionado:', window.selectedPlan);
    console.log('plan id:', planId);
    console.log('plan name:', planName);
    console.log('plan price:', planPrice);
};


// Función para cerrar el modal
window.closeModal = function () {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.add('hidden');
    } else {
        console.error('No se encontró el elemento con ID "paymentModal".');
    }
}

// Inicializar Mercado Pago con tu clave pública
const mp = new MercadoPago('{{$publicKey}}');

// Agregar evento de clic al botón de pago
document.getElementById('checkout-btn')?.addEventListener('click', function () {
    if (!window.selectedPlan) {
        console.error('No se seleccionó ningún plan.');
        return;
    }

    // Crear los datos del pedido
    const orderData = {
        product: [{
            title: window.selectedPlan.name,
            description: 'Descripción del producto', // Agregar una descripción específica aquí
            currency_id: "ARS",
            quantity: 1,
            unit_price: window.selectedPlan.price,
            id_pack: window.selectedPlan.idPackage
        }]
    };

    console.log('Datos del pedido:', orderData);
    

    // Realizar la solicitud al servidor para crear una preferencia de pago
    fetch('/create-preference', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value
        },
        body: JSON.stringify(orderData)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(preference => {
            if (preference.error) {
                throw new Error(preference.error);
            }

            // Redirigir al usuario a la URL de pago
            window.location.href = preference.init_point;
        })
        .catch(error => console.error('Error al crear la preferencia:', error));
});

// Verificar que el archivo JS se cargó correctamente
console.log('El archivo mercadopago.js se cargó exitosamente');
