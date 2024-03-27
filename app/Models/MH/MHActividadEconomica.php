<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHActividadEconomica extends Model
{
    use HasFactory;

    protected $table = 'mh_codigo_actividad_economica';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
        'tipo'
    ];

  

    
}
