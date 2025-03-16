<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHDepartamento extends Model
{
    use HasFactory;

    protected $table = 'mh_departamento';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];

  

    
}
