<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTributo extends Model
{
    use HasFactory;

    protected $table = 'mh_tributo';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
        'porcentaje',
        'tipo'
    ];
}
