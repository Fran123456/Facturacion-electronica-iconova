<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MH_tipo_documento extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_documento';

    protected $fillable = [
        'id',
        'codigo',
        'valor'
    ];
}
