<?php

namespace App\Models;

use App\Help\Services\InvalidarDte;
use App\Models\MH\MHTipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroDTE extends Model
{
    use HasFactory;

    protected $table = 'registro_dte';

    protected $fillable = [
        'id',
        'id_cliente',
        'id_empresa',
        'codigo_control',
        'codigo_generacion',
        'tipo_documento',
        'dte',
        'dte_mh',
        'numero_dte',
        'sello',
        'fecha_recibido',
        'observaciones',
        'estado',
        'empresa_id',
        'response',
        'dte_firmado',
        'anexo',
        'invalidacion_id',
        'id_interno','contingencia', 'json_productos','comentario'
    ];

    protected $casts = [
        'fecha_recibido' => 'datetime', // Reemplaza 'fecha' por el nombre de tu columna
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente')->withDefault();
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa')->withDefault();
    }

    public function tipoDocumento(){
        return $this->belongsTo(MHTipoDocumento::class, 'tipo_documento', 'codigo')->withDefault();
    }

    public function invalidado(){
        return $this->belongsTo(InvalidacionDte::class, 'invalidacion_id');
    }


}

