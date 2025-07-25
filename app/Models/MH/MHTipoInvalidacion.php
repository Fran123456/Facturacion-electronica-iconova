<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTipoInvalidacion extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_invalidacion';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];

  

    
}
