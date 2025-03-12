<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroInmueble extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nombre', 'direccion', 'ciudad', 'descripcion', 'precio', 'tipo'
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

