<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                    Editar Inmueble: {{ $inmueble->nombre }}
                </h2>

                <form method="POST" action="{{ route('inmuebles.update', $inmueble->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Sección de imagen -->
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-1/3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
                            <div class="h-48 w-full border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $inmueble->imagen) }}" 
                                     alt="Imagen del inmueble" 
                                     class="h-full w-full object-cover"
                                     onerror="this.src='{{ asset('images/placeholder-inmueble.jpg') }}'">
                            </div>
                        </div>
                        
                        <div class="w-full sm:w-2/3">
                            <label for="nueva_imagen" class="block text-sm font-medium text-gray-700 mb-2">Cambiar Imagen</label>
                            <input type="file" name="imagen" id="nueva_imagen" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">Formatos: JPEG, PNG (Max. 2MB)</p>
                            @error('imagen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" required
                                   value="{{ old('nombre', $inmueble->nombre) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
                            <select id="tipo" name="tipo" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach(['casa' => 'Casa', 'departamento' => 'Departamento',  'terreno' => 'Terreno'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipo', $inmueble->tipo) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dirección -->
                        <div class="md:col-span-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" required
                                   value="{{ old('direccion', $inmueble->direccion) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('direccion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ciudad -->
                        <div>
                            <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad *</label>
                            <input type="text" id="ciudad" name="ciudad" required
                                   value="{{ old('ciudad', $inmueble->ciudad) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('ciudad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700">Precio ($) *</label>
                            <input type="number" id="precio" name="precio" step="0.01" min="0" required
                                   value="{{ old('precio', $inmueble->precio) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('precio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion', $inmueble->descripcion) }}</textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('GestionarInmuebles.blade') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-md transition duration-300">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>