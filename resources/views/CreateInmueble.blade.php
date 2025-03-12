<x-app-layout>

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Crear Registro</h2>


    <form action="{{ route('registro-inmueble.store') }}" method="POST">
        @csrf
    

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" required
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" id="ciudad" required
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" required step="0.01"
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium" for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required
                class="w-full border-gray-300 rounded-lg shadow-sm p-2 mt-1 focus:ring focus:ring-blue-300">
                <option value="casa">Casa</option>
                <option value="departamento">Departamento</option>
                <option value="terreno">Terreno</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-lg shadow-md transition">
            Guardar
        </button>
    </form>
</div>



</x-app-layout>
