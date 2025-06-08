<?php

namespace App\Models;

use App\Models\MH\MHTipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDTE extends Model
{
    use HasFactory;

    protected $table = 'log_dte';

    protected $fillable = [
        'id',
        'id_cliente',
        'id_empresa',
        'numero_dte',
        'tipo_documento',
        'fecha',
        'hora',
        'error',
        'estado',
        'empresa_id','codigo_generacion'
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


}
