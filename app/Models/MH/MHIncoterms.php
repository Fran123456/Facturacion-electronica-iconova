<?php

namespace App\Models\MH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHIncoterms extends Model
{
    use HasFactory;

    protected $table = 'mh_incoterms';

    protected $fillable = [
        'id',
        'codigo',
        'valor',
    ];
}
