<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use App\Models\User; // Importar la clase User
use Illuminate\Support\Facades\Auth;

class DeleteUserController extends Controller
{
    public function destroy(int $id)
    {
        // Evitar eliminar al usuario actualmente autenticado
        if (auth()->user()->isAdmin()) {
            $user = User::findOrFail($id);
            if ($user->id === auth()->id()) {
                return redirect()->route('GestionarUsuarios')
                       ->with('error', 'No puedes eliminar tu propia cuenta');
            }
        
            // Eliminar el usuario
            $user->delete();
        
            return redirect()->route('GestionarUsuarios')->with('success', 'Usuario eliminado correctamente');
        }
        return redirect()->route('GestionarUsuarios')->with('error', 'No tienes permisos para realizar esta acción');
    }
}
