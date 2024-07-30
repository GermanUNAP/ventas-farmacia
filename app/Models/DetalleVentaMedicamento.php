<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaMedicamento extends Model
{
    use HasFactory;

    protected $table = 'detalleVentaMedicamento'; // Asegúrate de que el nombre de la tabla esté correctamente definido

    protected $fillable = [
        'id_venta',
        'id_medicamento',
        'cantidad',
        'precio_unidad',
        'precio_total',
    ];
}
