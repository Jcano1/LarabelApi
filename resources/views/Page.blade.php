<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Encabezado con botones -->
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $inmueble->nombre ?: $inmueble->direccion }}
                </h1>
            </div>

            <!-- Contenido principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                <!-- Imagen principal -->
                <div class="md:col-span-2">
                    <img src="{{ $imagen }}" alt="Imagen del inmueble"
                        class="w-96 h-96 object-cover rounded-lg shadow-md">
                </div>

                <!-- Sección izquierda -->
                <div>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Información básica</h2>
                        <div class="space-y-3">
                            <p><span class="font-medium">Dirección:</span> {{ $inmueble->direccion }}</p>
                            <p><span class="font-medium">Ciudad:</span> {{ $inmueble->ciudad }}</p>
                            <p><span class="font-medium">Tipo:</span> {{ ucfirst($inmueble->tipo) }}</p>
                            <p><span class="font-medium">Precio:</span> ${{ number_format($inmueble->precio, 2) }}</p>
                            @if($inmueble->habitaciones)
                                <p><span class="font-medium">Habitaciones:</span> {{ $inmueble->habitaciones }}</p>
                            @endif
                            @if($inmueble->metros_cuadrados)
                                <p><span class="font-medium">Área:</span> {{ $inmueble->metros_cuadrados }} m²</p>
                            @endif
                        </div>
                    </div>

                    <!-- Mapa (opcional) -->
                </div>

                <!-- Sección derecha -->
                <div>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Descripción</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ $inmueble->descripcion }}</p>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <button id="buttonAnadorCarrito">Haz clic aquí</button>

    <script>
        console.log(window.apiToken)
        function AnadirCarrito() {
            console.log('{{ auth()->user()->id }}')
            console.log('{{ $inmueble->id }}')
            fetch('/api/carrito', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${window.apiToken}`
                },
                body: `{
                
                    "user_id": {{ auth()->user()->id }},
                    "ContenidoCarrito": "{{ $inmueble->id }}"
            
                }`,

            })
                .then(response => response.json())
                .then(data => {
                    if (data.message == 'El usuario ya tiene un carrito activo') {
                        fetch(`/api/carrito/${data.data.carrito_id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${window.apiToken}`
                            },
                            body: `{
                
                    "user_id": {{ auth()->user()->id }},
                    "ContenidoCarrito": "{{ $inmueble->id }}"
            
                }`,

                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data)
                            })
                    }
                    console.log('Respuesta del servidor:', data.message);

                    console.log('Success:', data.data.carrito_id);

                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al añadir el inmueble al carrito');
                });
        }
        var añadirCarrito = document.getElementById('buttonAnadorCarrito');
        añadirCarrito.addEventListener('click', function () {
            AnadirCarrito();
        });
    </script>
    <script>
        var Dueño_id="{{ $inmueble->user_id }}"
        fetch(`/api/carrito/${Dueño_id}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${window.apiToken}`
                },

            })
        console.log("{{ $inmueble->user_id }}")
    </script>
</x-app-layout>