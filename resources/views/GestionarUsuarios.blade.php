<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
                <p class="text-gray-600 mt-1">Listado completo de usuarios registrados</p>
            </div>
            <div>
                @if(isset($error)){
                    <p>{{$error}}</p>
                }
                @endif
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($users as $user)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <!-- Información del usuario -->
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <p class="text-sm mt-1">
                                    @if($user->isAdmin())
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Administrador</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Usuario Normal</span>
                                    @endif
                                </p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Botón Reset Password -->
                                <form method="POST" action="">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-black rounded-md transition-colors"
                                            onclick="return confirm('¿Enviar correo de recuperación a {{ $user->email }}?')">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            Reset Password
                                        </div>
                                    </button>
                                </form>

                                <!-- Botón Toggle Admin -->
                                <form method="POST" action="{{ route('User.Admin', $user) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="px-4 py-2 {{ $user->isAdmin() ? 'bg-purple-500 hover:bg-purple-600' : 'bg-indigo-500 hover:bg-indigo-600' }} text-black rounded-md transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            {{ $user->isAdmin() ? 'Quitar Admin' : 'Hacer Admin' }}
                                        </div>
                                    </button>
                                </form>

                                <!-- Botón Eliminar -->
                                <form method="POST" action="{{ route('User.Delete', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-black rounded-md transition-colors"
                                            onclick="return confirm('¿Eliminar permanentemente a {{ $user->email }}?')">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>