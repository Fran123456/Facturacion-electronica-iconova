<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\help\Help;
use App\Models\RegistroDTE;

class Anexo
{
        public static function emailError($codigoGeneracion, $control, $e){
            $obj =  RegistroDte::where('codigo_generacion',$codigoGeneracion)->
            where('numero_dte',$control)->first();
           if($obj != null){
            $obj->anexo = "El correo no se ha podido enviar correctamente por conexión de red interna " .  $e;
            $obj->save();
           }
        }

}