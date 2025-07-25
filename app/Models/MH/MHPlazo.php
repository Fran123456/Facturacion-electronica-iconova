<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHPlazo extends Model
{
    use HasFactory;

    protected $table = 'mh_plazo';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];    
}
