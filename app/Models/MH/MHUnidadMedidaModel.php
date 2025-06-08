<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHUnidadMedidaModel extends Model
{
    use HasFactory;

    protected $table = 'mh_unidad_medida';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];
}
