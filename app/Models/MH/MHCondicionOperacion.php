<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHCondicionOperacion extends Model
{
    use HasFactory;

    protected $table = 'mh_condicion_operacion';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];    
}
