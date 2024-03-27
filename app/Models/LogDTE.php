<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDTE extends Model
{
    use HasFactory;

    protected $table = 'log_dte';

    protected $fillable = [
        'id',
        'id_cliente',
        'numero_dte',
        'tipo_documento',
        'fecha',
        'hora',
        'error',
        'estado'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente')->withDefault();
    }
}
