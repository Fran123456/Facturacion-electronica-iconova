<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHPais extends Model
{
    use HasFactory;

    protected $table = 'mh_pais';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];
}
