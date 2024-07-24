<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['id_usuario', 'dni_comprador', 'nombre_comprador', 'precio_pagar', 'fecha', 'puntos_extra'];
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
}
