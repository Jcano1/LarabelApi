<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Necesario para manejar archivos

class DeleteInmuebleController extends Controller
{
    public function destroy($id)
    {
        // Validar que el inmueble exista
        $inmueble = RegistroInmueble::findOrFail($id);
        
        // Verificar propiedad
        if ($inmueble->user_id != Auth::id()) {
            return back()->with('error', 'No tienes permiso para eliminar este inmueble');
        }
        
        // Eliminar la imagen si existe
        if ($inmueble->imagen) {
            Storage::disk('public')->delete($inmueble->imagen);
        }
        
        // Eliminar el registro de la base de datos
        $inmueble->delete();
        
        return redirect()->route('GestionarInmuebles.blade')
               ->with('success', 'Inmueble eliminado correctamente');
    }
}