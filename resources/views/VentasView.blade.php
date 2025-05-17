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
            console.log({{ auth()->id() }})
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

                    container.innerHTML = `
                        <p><strong>ID del Carrito:</strong> ${carrito.id}</p>
                        <p><strong>Usuario:</strong> ${carrito.user_id}</p>
                        <p><strong>Creado el:</strong> ${new Date(carrito.created_at).toLocaleString()}</p>
                        <p><strong>Productos Vendidos:</strong> ${carrito.ContenidoCarrito}</p>
                    `;
                } else if (data.message === "Book not found") {
                    container.innerHTML = `
                        <p class="text-yellow-600">No tienes ningún carrito asignado aún.</p>
                    `;
                } else {
                    container.innerHTML = `
                        <p class="text-red-600">Error: ${data.message || 'No se pudo obtener el carrito.'}</p>
                    `;
                }
            } catch (error) {
                container.innerHTML = `<p class="text-red-600">Error al conectar con el servidor.</p>`;
                console.error(error);
            }
        });
    </script>
    @endsection
</x-app-layout>
