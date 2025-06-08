<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHMunicipio extends Model
{
    use HasFactory;

    protected $table = 'mh_municipio';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
        'departamento'
    ];

  

    
}
