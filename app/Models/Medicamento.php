<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'cantidad', 'precio_unidad_vender', 'precio_venta', 'precio_comprado', 'vencimiento', 'lote'];
}
