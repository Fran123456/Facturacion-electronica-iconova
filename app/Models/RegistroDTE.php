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
        'numero_dte',
        'tipo_documento',
        'dte',
        'estado',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente')->withDefault();
    }
}

