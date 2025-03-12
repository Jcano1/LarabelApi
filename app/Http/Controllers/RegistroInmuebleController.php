<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use Illuminate\Support\Facades\Auth;

class RegistroInmuebleController extends Controller
{


    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|in:casa,departamento,terreno',
        ]);

        RegistroInmueble::create([
            'user_id' => Auth::id(), // Se asocia al usuario autenticado
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('dashboard')->with('success', 'Inmueble creado con éxito.');
    }
}
?>