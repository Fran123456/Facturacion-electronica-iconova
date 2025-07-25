<?php

namespace App\Help\DTEIdentificacion;

use App\Help\Generator;
use App\Help\Help;
use App\Models\RegistroDTE;
use Illuminate\Support\Facades\Crypt;

class Invalidacion
{

    public static function identificacion()
    {

        $empresa = Help::getEmpresa();
        $fechaHora = new \DateTime();

        $fecha = $fechaHora->format('Y-m-d');
        $hora = $fechaHora->format('H:i:s');

        $generado = Generator::generateCodeGeneration();
        $generadoDB = RegistroDTE::where('codigo_generacion', $generado)->first();
        if($generadoDB){
            $generado = Generator::generateCodeGeneration();


            $generadoDB = RegistroDTE::where('codigo_generacion', $generado)->first();
            if($generadoDB){
                $generado = Generator::generateCodeGeneration();
            }

        }else{

        }
       


        $identificacion =  [
            "version" => 2,
            "ambiente" => $empresa->ambiente,
            "codigoGeneracion" => $generado,
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
