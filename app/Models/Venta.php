<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni_comprador',
        'total'
    ];

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class)->withPivot('cantidad', 'precio_unidad_vender');
    }
}
