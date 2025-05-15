<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompras extends Model
{
    /** @use HasFactory<\Database\Factories\CarritoComprasFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id', 'ContenidoCarrito'
    ];
}
