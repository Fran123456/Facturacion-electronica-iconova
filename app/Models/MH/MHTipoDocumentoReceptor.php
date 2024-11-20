<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTipoDocumentoReceptor extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_documento_identificacion_receptor';

    protected $fillable = [
        'id',
        'codigo',
        'valor'
    ];
}
