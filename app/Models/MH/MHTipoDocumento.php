<?php

namespace App\Models\MH;

use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHTipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'mh_tipo_documento';

    protected $guarded = [];

    public function logDte()
    {
        return $this->hasMany(LogDTE::class, 'tipo_documento', 'codigo');
    }

    public function registroDte()
    {
        return $this->hasMany(RegistroDTE::class, 'tipo_documento', 'codigo');
    }
}
