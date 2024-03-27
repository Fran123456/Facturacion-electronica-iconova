<?php

namespace App\Help;

use App\Models\Config;

class DteCodeValidator
{

    //415 Unsupported Media Type
    public static function code415($data)
    {
        return array(
            "error" => "Los datos  enviados no son los adecuados Unsupported Media Type",
            "data" => $data
        );
    }
    // 401 Unauthorized
    public static function code401()
    {
        return array("error" => "No se ha podido loguear correctamente, validar token de ministerio de hacienda o credenciales");
    }

    public static function code404($error = null)
    {
        if ($error == null) {
            $error = "Error generico, comuniquese con el administrador";
        } else {
        }
        return array("error" => $error);
    }
}
