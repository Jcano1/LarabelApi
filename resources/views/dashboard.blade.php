<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Lista de Inmuebles Disponibles</h1>

        @if($inmuevles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($inmuevles as $inmueble)
                    <a href="{{ route('Page', $inmueble->id) }}" class="block hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col h-full">
                            <!-- Imagen -->
                            <div class="w-full aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $inmueble->imagen) }}" 
                                     alt="Imagen del inmueble" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </div>

                            <div class="p-4 flex-grow">
                                <h2 class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $inmueble->direccion }}, {{ $inmueble->ciudad }}
                                </h2>
                                <p class="text-gray-600 text-sm mt-1 line-clamp-2">
                                    {{ $inmueble->descripcion }}
                                </p>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-bold text-blue-600">
                                        ${{ number_format($inmueble->precio, 2) }}
                                    </span>
                                    <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full">
                                        {{ ucfirst($inmueble->tipo) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-600">No hay inmuebles disponibles en este momento.</p>
                @auth
                    <a href="{{ route('inmuebles.create') }}" 
                       class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md">
                        Crear nuevo inmueble
                    </a>
                @else
                    <p class="mt-4 text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="text-blue-600">Inicia sesión</a> para gestionar inmuebles.
                    </p>
                @endauth
            </div>
        @endif
    </div>
</x-app-layout>