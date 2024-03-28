<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHFormaPago extends Model
{
    use HasFactory;

    protected $table = 'mh_forma_pago';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];
}
