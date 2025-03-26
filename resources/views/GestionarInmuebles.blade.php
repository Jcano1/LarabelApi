<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mis Inmuebles</h1>
            <a href="{{ route('CreateInmueble.blade') }}" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-md transition duration-300">
                Añadir Nuevo Inmueble
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @foreach($inmuebles as $inmueble)
            <div class="border-b border-gray-200 last:border-b-0 p-6 flex gap-6 items-start">
                <!-- Contenedor de imagen -->
                <img src="{{ asset('storage/' . $inmueble->imagen) }}" 
                     alt="Imagen del inmueble {{ $inmueble->direccion }}"
                     class="w-48 h-48 object-cover hover:scale-105 transition-transform duration-300"
                     >

                <!-- Contenedor de información -->
                <div class="flex-1 min-w-0 flex flex-col">
                    <div class="flex items-center gap-4 mb-2">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">
                            {{ $inmueble->direccion }}, {{ $inmueble->ciudad }}
                        </h2>
                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">
                            {{ ucfirst($inmueble->tipo) }}
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ${{ number_format($inmueble->precio, 2) }}
                        </p>
                        
                        @if($inmueble->habitaciones)
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ $inmueble->habitaciones }} hab.
                        </p>
                        @endif
                        
                        @if($inmueble->metros_cuadrados)
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            {{ $inmueble->metros_cuadrados }} m²
                        </p>
                        @endif
                    </div>
                    
                    @if($inmueble->descripcion)
                    <p class="mt-2 text-gray-600 line-clamp-2">
                        {{ $inmueble->descripcion }}
                    </p>
                    @endif

                    <!-- Botones de acción -->
                    <div class="mt-auto pt-4 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('inmuebles.edit', $inmueble->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md transition duration-300 flex items-center ">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar
                        </a>
                        
                        <form action="{{ route('inmuebles.destroy', $inmueble->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-black px-4 py-2 rounded-md transition duration-300 flex items-center justify-center"
                                    onclick="return confirm('¿Estás seguro de querer eliminar este inmueble?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        @if($inmuebles->hasPages())
        <div class="mt-6">
            {{ $inmuebles->links() }}
        </div>
        @endif
        
        <!-- Mensaje cuando no hay inmuebles -->
        @if($inmuebles->isEmpty())
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-500 mb-4">No tienes inmuebles registrados</p>
            <a href="{{ route('CreateInmueble.blade') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300">
                Añadir mi primer inmueble
            </a>
        </div>
        @endif
    </div>
</x-app-layout>
