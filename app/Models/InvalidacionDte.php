<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvalidacionDte extends Model
{
    use HasFactory;

    protected $table = 'invalidacion_dte';

    protected $fillable = [
        'id',
        'respuesta',
        'sello',
        'codigo_generacion',
        'dte_firmado',
        'dte'
    ];
}
