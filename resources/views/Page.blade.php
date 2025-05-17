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

    {{-- Mostrar botones solo si está logueado --}}
    @auth
        <div class="flex space-x-4 mt-4">
            <button 
                id="buttonAnadorCarrito"
                class="px-6 py-3 text-black font-medium rounded-lg shadow-md">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Añadir al carrito
                </div>
            </button>

            <div id="ContainerBtCompra">
                <button 
                    id="buttonComprar"
                    class="w-full px-6 py-3 text-black font-medium rounded-lg shadow-md">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Comprar ahora
                    </div>
                </button>
            </div>
        </div>

        {{-- Scripts solo si está logueado --}}
        <script>
            function AnadirCarrito() {
                fetch('/api/carrito', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${window.apiToken}`
                    },
                    body: JSON.stringify({
                        user_id: {{ auth()->user()->id }},
                        ContenidoCarrito: "{{ $inmueble->id }}"
                    }),
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
                            body: JSON.stringify({
                                user_id: {{ auth()->user()->id }},
                                ContenidoCarrito: "{{ $inmueble->id }}"
                            }),
                        }).then(response => response.json())
                          .then(data => console.log(data));
                    }
                    console.log('Respuesta del servidor:', data.message);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al añadir el inmueble al carrito');
                });
            }

            function TramitarCompra() {
                const dueñoId = "{{ $inmueble->user_id }}";

                fetch('/api/CarritoCompras', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${window.apiToken}`
                    },
                    body: JSON.stringify({
                        user_id: dueñoId,
                        ContenidoCarrito: "{{ $inmueble->id }}"
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    data = data.data;
                    let ContenidoCarrito = data.ContenidoCarrito.split(';');
                    if (!ContenidoCarrito.includes("{{ $inmueble->id }}")) {
                        ContenidoCarrito.push("{{ $inmueble->id }}");
                        fetch(`/api/CarritoCompras/${data.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${window.apiToken}`
                            },
                            body: JSON.stringify({
                                ContenidoCarrito: ContenidoCarrito.join(';')
                            }),
                        }).then(res => res.json())
                          .then(console.log);
                    } else {
                        Vendido();
                    }
                });
            }

            function Vendido() {
                const dueñoId = "{{ $inmueble->user_id }}";
                fetch(`/api/CarritoCompras/${dueñoId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${window.apiToken}`
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message !== "Carrito no encontrado") {
                        let ids = data.data.ContenidoCarrito.split(';');
                        if (ids.includes("{{ $inmueble->id }}")) {
                            document.getElementById('ContainerBtCompra').innerHTML = `
                                <p id="buttonComprar" disabled class="w-full px-6 py-3 text-black font-medium rounded-lg shadow-md flex items-center justify-center bg-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Vendido
                                </p>`;
                        }
                    }
                });
            }

            document.getElementById('buttonAnadorCarrito').addEventListener('click', AnadirCarrito);
            document.getElementById('buttonComprar').addEventListener('click', TramitarCompra);

            Vendido(); // Verificar al cargar si ya está vendido
        </script>
    @endauth
</x-app-layout>
