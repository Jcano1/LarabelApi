<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarritoRequest;
use App\Http\Requests\UpdateCarritoRequest;
use App\Models\Carrito;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carritos = Carrito::all();
        if (!$carritos->isEmpty()) {
            return response()->json([
                'message' => 'Books listed successfully',
                'data' => $carritos
            ], 200);
        } else {
            return response()->json([
                'message' => 'No books found',
            ], 404);
        }
    }

    public function store(StoreCarritoRequest $request)
    {
        $validated = $request->validated();

        // Verificar si el usuario ya tiene un carrito
        $existeCarrito = Carrito::where('user_id', $validated['user_id'])->first();

        if ($existeCarrito) {
            return response()->json([
                'message' => 'El usuario ya tiene un carrito activo',
                'data' => [
                    'carrito_id' => $existeCarrito->id
                ]
            ], 200); // Puedes usar 200 OK si solo quieres devolver el existente
        }

        // Crear el carrito
        $Carrito = Carrito::create($validated);

        return response()->json([
            'message' => 'Carrito creado exitosamente',
            'data' => [
                'carrito_id' => $Carrito->id
            ]
        ], 201);
    }
    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $Carrito = Carrito::where('user_id', $user_id)->first();
    
        if ($Carrito) {
            return response()->json([
                'message' => 'Book found successfully',
                'data' => $Carrito
            ], 200);
        } else {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarritoRequest $request, $id)
    {
        $carrito = Carrito::find($id);
        if (!$carrito) {
            return response()->json([
                'message' => 'Carrito no encontrado',
            ], 404);
        }

        $validated = $request->validated();

        // Contenido actual (en string tipo "Producto A; Producto B")
        $contenidoActual = $carrito->ContenidoCarrito ?? '';

        // Convertir a array limpio de productos actuales
        $productosActuales = array_filter(array_map('trim', explode(';', $contenidoActual)));

        // Producto nuevo recibido (puedes recibir uno o varios separados por ';' si deseas)
        $nuevoContenido = $validated['ContenidoCarrito'] ?? '';

        // Convertimos también el nuevo contenido a array por si vienen múltiples productos
        $nuevosProductos = array_filter(array_map('trim', explode(';', $nuevoContenido)));

        $productosAgregados = [];

        foreach ($nuevosProductos as $producto) {
            if (!in_array($producto, $productosActuales)) {
                $productosActuales[] = $producto;
                $productosAgregados[] = $producto;
            }
        }

        // Actualizamos el carrito solo si hubo productos nuevos agregados
        if (!empty($productosAgregados)) {
            $carrito->ContenidoCarrito = implode('; ', $productosActuales);
            $carrito->save();

            return response()->json([
                'message' => 'Productos añadidos al carrito exitosamente',
                'data' => [
                    'carrito_id' => $carrito->id,
                    'ContenidoCarrito' => $carrito->ContenidoCarrito,
                    'productos_nuevos_agregados' => $productosAgregados
                ]
            ], 200);
        } else {
            return response()->json([
                'message' => 'Todos los productos ya estaban en el carrito',
                'data' => [
                    'carrito_id' => $carrito->id,
                    'ContenidoCarrito' => $carrito->ContenidoCarrito
                ]
            ], 200);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carrito = Carrito::find($id);
        if ($carrito) {
            $carrito->delete();
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    }
}
