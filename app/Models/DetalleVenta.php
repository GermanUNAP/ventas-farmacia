<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = ['id_venta', 'id_medicamento', 'cantidad', 'precio_unidad', 'precio_total'];

    // Especifica el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'detalleVentaMedicamento';

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }
}
