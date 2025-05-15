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

    public function store(StoreCarritoRequest $request)
    {

        $validated = $request->validated();
        $Carritos=Carrito::create($validated);
        return response()->json([
        'message'=>'Book created successfully',
        'data'=>$Carritos
        ],201);

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
    public function show($id)
    {
        $Carrito=Carrito::find($id);
        if($Carrito){
            return response()->json([
            'message'=>'Book found successfully',
            'data'=>$Carrito
            ],200);
        }else{
            return response()->json([
            'message'=>'Book not found',
            ],404);
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
        $carrito=Carrito::find($id);
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
        $carrito=Carrito::find($id);
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
}
