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
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Máximo 5MB
        ]);
    
        $data = $request->all();
        $data['user_id'] = Auth::id();
    
        // Verifica si la imagen está presente y es válida
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $path = $request->file('imagen')->store('photos', 'public'); // Guarda en storage/app/public/photos
            $data['imagen'] = $path;
        } else {
            return back()->with('error', 'Error al subir la imagen.');
        }
    
        RegistroInmueble::create($data);
    
        return redirect()->route('dashboard')->with('success', 'Inmueble creado con éxito.');
    }
}
?>