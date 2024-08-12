<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroDTE extends Model
{
    use HasFactory;

    protected $table = 'registro_dte';

    protected $fillable = [
        'id',
        'id_cliente',
        'codigo_generacion',
        'tipo_documento',
        'dte',
        'numero_dte',
        'sello',
        'fecha_recibido',
        'observaciones',
        'estado',
        'empresa_id'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente')->withDefault();
    }
}

