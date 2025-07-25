<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTipoEstablecimiento extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_establecimiento';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];

  

    
}
