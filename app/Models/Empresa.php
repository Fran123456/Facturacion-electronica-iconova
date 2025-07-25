<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresa";

    protected $fillable = [
        'correo_pdf',
        'id_usuario',
        'nombre',
        'public_key',
        'private_key',
        'token_mh',
        'correo_electronico',
        'telefono',
        'celular',
        'codigo_actividad',
        'nombre_comercial',
        'departamento',
        'municipio',
        'direccion',
        'nrc',
        'codigo_establecimiento',
        'ambiente',
        'correlativo_ccf',
        'correlativo_cd',
        'correlativo_cl',
        'correlativo_cr',
        'correlativo_dcl',
        'correlativo_fc',
        'correlativo_fex',
        'correlativo_fse',
        'correlativo_nota_credito',
        'correlativo_nd',
        'correlativo_nr',
        'contingencia_interno'
    ];

    public function empresa()
    {
        return $this->belongsToMany(User::class, "id_usuario")->withDefault();
    }
}
