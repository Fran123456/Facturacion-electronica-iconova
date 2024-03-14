<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIEmpresa extends Model
{
    use HasFactory;

    protected $table = "empresa";

    protected $fillable = [
        'id_usuario',
        'nombre',
        'public_key',
        'private_key',
    ];

    public function empresa(){
        return $this->belongsToMany(User::class, "id_usuario")->withDefault();
    }
}
