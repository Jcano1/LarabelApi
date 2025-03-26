<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Necesario para el manejo de imágenes

class EditInmuebleController extends Controller
{
    public function edit(RegistroInmueble $inmueble)
    {
        // Verificar que el usuario es propietario
        if ($inmueble->user_id != auth()->id()) {
            abort(403, 'No tienes permiso para editar este inmueble');
        }

        return view('EditInmueble', compact('inmueble'));
    }

    public function update(Request $request, RegistroInmueble $inmueble)
    {
        // Verificar propiedad
        if ($inmueble->user_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:casa,apartamento,local,terreno',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($inmueble->imagen) {
                Storage::disk('public')->delete($inmueble->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('photos', 'public');
        }

        $inmueble->update($validated);

        return redirect()->route('GestionarInmuebles.blade')
               ->with('success', 'Inmueble actualizado correctamente');
    }
}