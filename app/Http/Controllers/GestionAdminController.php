<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Importar el modelo User
use App\Models\UserRole; // Importar el modelo user_roles

class GestionAdminController extends Controller
{
    public function GestionarAdmin(User $user)
    {
        if(auth()->user()->isAdmin()){
        // Evitar modificar al usuario actualmente autenticado
        if ($user->id === auth()->id()) {
            return redirect()->route('GestionarUsuarios')
                   ->with('error', 'No puedes modificar tus propios privilegios de administrador');
        }
    
        // Verificar si el usuario ya es admin
        $isAdmin = $user->roles()->where('role_id', 2)->exists();
    
        if ($isAdmin) {
            // Remover rol de admin
            $user->roles()->detach(2);
            $message = 'Rol de administrador removido correctamente';
        } else {
            // Asignar rol de admin
            $user->roles()->attach(2);
            $message = 'Usuario promovido a administrador exitosamente';
        }
    
        return redirect()->route('GestionarUsuarios')->with('success', $message);
    }
    return redirect()->route('GestionarUsuarios')->with('error', 'No tienes permisos para realizar esta acción');
    }

}