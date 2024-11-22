<?php

namespace App\Help\DTEIdentificacion;

use App\Help\Generator;
use App\help\Help;
use App\Models\MH\MHActividadEconomica;
use Illuminate\Support\Facades\Crypt;

class Invalidacion
{

    public static function identificacion()
    {

        $empresa = Help::getEmpresa();
        $fechaHora = new \DateTime();

        $fecha = $fechaHora->format('Y-m-d');
        $hora = $fechaHora->format('H:i:s');

        $identificacion =  [
            "version" => 2,
            "ambiente" => $empresa->ambiente,
            "codigoGeneracion" => Generator::generateCodeGeneration(),
            "fecAnula" => $fecha,
            "horAnula" => $hora,
        ];

        return $identificacion;
    }

    public static function emisor($tipoEstablecimiento = null)
    {

        $empresa = Help::getEmpresa();
        $usuario = Help::getUsuario();
        $nit = Crypt::decryptString($empresa->nit);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $telefono = Crypt::decryptString($empresa->telefono);
        $correo = Crypt::decryptString($empresa->correo_electronico);

        $emisor = [
            "nit" => $nit,
            "nombre" => $usuario->name,
            "tipoEstablecimiento" => $tipoEstablecimiento ?? '02',
            "telefono" => $telefono,
            "correo" => $correo,
            "codEstable"=>  null,
            "codPuntoVenta" =>  null,
            "nomEstablecimiento" => $nombreEmpresa,
        ];

        return $emisor;
    }
}
