<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresa";

    protected $fillable = [
        'id_usuario',
        'nombre',
        'public_key',
        'private_key','token_mh',
        'correo_electronico','telefono','celular','correlativo_fex'
        ,'codigo_actividad','nombre_comercial','departamento','municipio','direccion',
        'nrc','codigo_establecimiento','ambiente'
    ];

    public function empresa(){
        return $this->belongsToMany(User::class, "id_usuario")->withDefault();
    }
}
