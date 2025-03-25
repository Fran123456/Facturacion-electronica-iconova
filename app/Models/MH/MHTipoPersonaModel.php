<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTipoPersonaModel extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_persona';

    protected $fillable = [
        'id',
        'codigo',
        'valor'
    ];
}
