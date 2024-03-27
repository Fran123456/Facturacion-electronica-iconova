<?php

namespace App\Help\DTEIdentificacion;

use App\Models\Config;
use App\Help\Generator;
use Illuminate\Support\Facades\Crypt;
use App\Models\MH\MHActividadEconomica;
use App\Help\Help;
class Identificacion
{

    public static function identidad($tipoDoc)
    {
        $fecha_actual = new \DateTime();
        $identificacion =  [
            "version" => 1,
            "ambiente" => "00",
            "tipoDte" => "11",
            "numeroControl" =>  Generator::generateNumControl($tipoDoc),
            "codigoGeneracion" => Generator::generateCodeGeneration(),
            "tipoOperacion" => 1,
            "tipoModelo" => 1,
            "tipoContingencia" => null,
            "motivoContigencia" => null,
            "fecEmi" => $fecha_actual->format('Y-m-d'),
            "horEmi" => $fecha_actual->format('H:i:s'),
            "tipoMoneda" => "USD"
         ] ;
        return $identificacion;
    }

    public static function emisor($tipoEstablecimiento)
    {

        $empresa = Help::getEmpresa();
        
        $nit = Crypt::decryptString($empresa->nit);
        $nrc = Crypt::decryptString($empresa->nrc);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $actividad =MHActividadEconomica::where('codigo',$empresa->codigo_actividad)->first();

       
        $emisor = [
            "nit" => $nit,
            "nrc" =>  $nrc,
            "nombre" => $nombreEmpresa,
            "codActividad" => $empresa->codigo_actividad,
            "descActividad" => $actividad->valor,
            "nombreComercial" => $empresa->nombre_comercial,
            "tipoEstablecimiento" => $tipoEstablecimiento,
            "direccion" => [
                "departamento" => $empresa->departamento,
                "municipio" => $empresa->municipio,
                "complemento" => $empresa->direccion
            ],
            "telefono" => "00000000",
            "correo" => "PRIETO@HOTMAIL.COM",
            "codEstableMH" => "M001",
            "codPuntoVentaMH" => "P001",
            "tipoItemExpor" => 1,
            "recintoFiscal" => "01",
            "regimen" => "EX-1.1000.000"
        ];
        return $emisor;
    }

   
}
