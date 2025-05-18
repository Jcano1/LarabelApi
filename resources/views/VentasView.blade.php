<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tu Carrito de Compras</h1>

        <div id="carrito-container" class="bg-white shadow rounded-lg p-6 text-gray-700">
            <p>Cargando carrito...</p>
        </div>
    </div>
    
    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const container = document.getElementById('carrito-container');
            const userId = {{ auth()->id() }};
            const token = "{{ session('api_token') }}";

            try {
                const response = await fetch(`/api/CarritoCompras/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });



                const data = await response.json();

                if (response.ok && data.data) {
                    const carrito = data.data;

                    const InfoInmuebles = await fetch(`/api/InfoProductosVenta`, {
                        method: 'POST',
                        headers: {

                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            'ContenidoCarrito': carrito.ContenidoCarrito
                        })
                    })
                    var dataInmuebles = await InfoInmuebles.json();

                    var htmlInmuebles = '';
                    for (dataInmueble of dataInmuebles.data) {

                        console.log(dataInmueble)
                        htmlInmuebles += ` <br><a href="inmuebles/${dataInmueble.id}" style="text-decoration: none; color: inherit; display: inline-block;">
                                                <div style="background-color: #f3f4f6; padding: 16px; margin-bottom: 16px; border-radius: 8px; max-width: 500px; font-family: Arial, sans-serif; text-align: center;">
                                                    <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 12px;">${dataInmueble.nombre}</h2>
                                                    <img src="/storage/${dataInmueble.imagen}" alt="Imagen del inmueble" style="width: 100%; max-width: 300px; height: auto; object-fit: cover; border-radius: 8px; margin-bottom: 12px; display: block; margin-left: auto; margin-right: auto;">
                                                    <p style="margin: 6px 0;"><strong>Precio:</strong> $${dataInmueble.precio}</p>
                                                    <p style="margin: 6px 0;"><strong>Descripción:</strong> ${dataInmueble.descripcion}</p>
                                                    <p style="margin: 6px 0;"><strong>Ubicación:</strong> ${dataInmueble.ciudad}</p>
                                                </div>
                                            </a>



                            `;
                    }

                    container.innerHTML = `
                            <p><strong>ID del Carrito:</strong> ${carrito.id}</p>
                            <p><strong>Usuario:</strong> ${carrito.user_id}</p>
                            <p><strong>Creado el:</strong> ${new Date(carrito.created_at).toLocaleString()}</p>
                            <div><strong>Productos en el carrito:</strong> ${htmlInmuebles}</div>
                        `;
                } else if (data.message === "Book not found") {
                    container.innerHTML = `
                            <p class="text-yellow-600">No tienes ningún carrito asignado aún.</p>
                        `;
                } else {
                    container.innerHTML = `
                            <p class="text-black">No tienes ventas</p>
                        `;
                }
            } catch (error) {
                container.innerHTML = `<p class="text-red-600">Error al conectar con el servidor.</p>`;
            }
        });
    </script>
    @endsection
</x-app-layout>
