<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarritoComprasRequest;
use App\Http\Requests\UpdateCarritoComprasRequest;
use App\Models\CarritoCompras;
use Illuminate\Http\Request;
use App\Models\registroInmueble;

class CarritoComprasController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carritos = CarritoCompras::all();
        if(!$carritos->isEmpty()){
            return response()->json([
                'message'=>'Books listed successfully',
                'data'=>$carritos
                ],200);
            }else{
            return response()->json([
            'message'=>'No books found',
            ],404);
            }
    }

    public function store(StoreCarritoComprasRequest $request)
    {
        $validated = $request->validated();
    
        // Buscar carrito existente por user_id
        $existingCarrito = CarritoCompras::where('user_id', $validated['user_id'])->first();
        if ($existingCarrito) {
            return response()->json([
                'message' => 'El usuario ya tiene un carrito asignado.',
                'data' => $existingCarrito
            ], 200); // OK, pero indicando que no se creó uno nuevo
        }
    
        $Carritos = CarritoCompras::create($validated);
        return response()->json([
            'message' => 'Carrito creado exitosamente',
            'data' => $Carritos
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
        $Carrito = CarritoCompras::where('user_id', $user_id)->first();
    
        if (is_null($Carrito)) {
            return response()->json([
                'message' => 'Carrito no encontrado',
            ], 404);
        }
    
        return response()->json([
            'message' => 'Carrito encontrado exitosamente',
            'data' => $Carrito
        ], 200);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarritoComprasRequest $request, $id)
    {
        $carrito=CarritoCompras::find($id);
        if(!$carrito){
            return response()->json([
            'message'=>'Book not found',
            ],404);
        }else{
            $validated = $request->validated();
  
            $carrito->update($validated);
            return response()->json([
            'message'=>'Book updated successfully',
            'data'=>$carrito
            ],200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carrito=CarritoCompras::find($id);
    if($carrito){
        $carrito->delete();
        return response()->json([
        'message'=>'Book deleted successfully',
        ],200);
    }else{
        return response()->json([
        'message'=>'Book not found',
        ],404);
    }
    }
    public function GetDatos(Request $request)
    {
        $listaId = $request->input('ContenidoCarrito');
    
        // Convertimos el string en array y limpiamos espacios
        $listaId = array_filter(array_map('trim', explode(';', $listaId)));
    
        // Buscamos los inmuebles
        $inmuebles = registroInmueble::whereIn('id', $listaId)->get();
    
        if ($inmuebles->isNotEmpty()) {
            return response()->json([
                'message' => 'Inmuebles encontrados correctamente',
                'data' => $inmuebles
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontraron inmuebles',
                'data' => []
            ], 404);
        }
    }
}
