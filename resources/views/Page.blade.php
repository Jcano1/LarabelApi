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
                    <img src="{{ $imagen }}" 
                         alt="Imagen del inmueble"
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
</x-app-layout>