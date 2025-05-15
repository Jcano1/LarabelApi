<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroInmueble;
use Illuminate\Support\Facades\Storage;

class PageInmuebleController extends Controller
{
    /**
     * Muestra el detalle de un inmueble
     */
    public function show(RegistroInmueble $inmueble)
    {

        $imagen = Storage::disk('public')->exists($inmueble->imagen) 
                ? asset('storage/'.$inmueble->imagen) 
                : asset('images/placeholder-inmueble.jpg');

        return view('Page', [
            'inmueble' => $inmueble,
            'imagen' => $imagen
        ]);
    }

}