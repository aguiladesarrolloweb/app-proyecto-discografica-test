window.paypal
    .Buttons({
        style: {
            shape: "rect",
            layout: "vertical",
            color: "gold",
            label: "paypal",
        },

        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [
                    {
                        amount: {
                            value: window.selectedPlan.price,
                        },
                    },
                ],
                description: window.selectedPlan.name,
            });
        },
        onApprove: function(data, actions) {
            // El payerID viene de la respuesta de PayPal después de la aprobación
            const payerId = data.payerID;
            console.log(data);
        
            // Enviar el payerId junto con el orderID al backend para completar la captura
            axios.post("/api/orders/" + data.orderID + "/capture", {
                payer_id: payerId  // Pasamos el payer_id al backend
            }
        
        )
            .then(response => {
                if (response.data.status === 'success') {
                    alert("Pago completado con éxito.");
                } else {
                    alert("Error al procesar el pago." + response.data.status);
                }
            })
            .catch(error => {
                alert("Ocurrió un error. Inténtalo de nuevo: " + error);
            });
        },
        
    })
    .render("#paypal-button-container");
