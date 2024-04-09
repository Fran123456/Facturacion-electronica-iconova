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
        'codigo_activad',
        'descripcion_activad',
        'nombre_comercial',
        'departamento',
        'municipio',
        'complemento',
        'telefono',
        'correo',
        'estado',
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
