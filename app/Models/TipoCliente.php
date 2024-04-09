<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    use HasFactory;

    protected $table = "tipo_cliente";

    protected $fillable = [
        'id',
        'tipo'
    ];

    public function Cliente(){
        return $this->hasMany(Cliente::class, 'id_tipo_cliente', 'id');
    }
}
