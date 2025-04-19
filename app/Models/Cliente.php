<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        'id',
        'id_tipo_cliente',
        'tipo_documento',
        'nit',
        'nrc',
        'dui',
        'nombre',
        'descripcion_actividad',
        'codigo_actividad',
        'nombre_comercial',
        'departamento',
        'municipio',
        'complemento',
        'telefono',
        'correo',
        'estado',
        'otro_documento'
    ];

    public function logDTE(){
        return $this->hasMany(LogDTE::class, 'id_cliente', 'id');
    }

    public function registroDTE(){
        return $this->hasMany(RegistroDTE::class, 'id_cliente', 'id');
    }

    public function tipoCliente(){
        $this->belongsToMany(TipoCliente::class, 'id_tipo_cliente')->withDefault();
    }
}
