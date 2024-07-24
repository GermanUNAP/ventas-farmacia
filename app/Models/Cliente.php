<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public $timestamps = false;
    // Define los atributos que pueden ser asignados masivamente
    protected $fillable = ['name', 'email', 'dni', 'points'];
}
