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
            "tipoDte" => $tipoDoc,
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

    public static function emisor($tipoDoc,$tipoEstablecimiento, $puntoDeVentaCodigo, $recintoFiscal)
    {

        $empresa = Help::getEmpresa();
        
        $nit = Crypt::decryptString($empresa->nit);
        $nrc = Crypt::decryptString($empresa->nrc);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $telefono = Crypt::decryptString($empresa->telefono);
        $correo = Crypt::decryptString($empresa->correo_electronico);
        
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
            "telefono" => $telefono,
            "correo" => $correo,
            "codEstableMH" => $empresa->codigo_establecimiento,
            "codPuntoVentaMH" => $puntoDeVentaCodigo??$empresa->codigo_establecimiento,
            "tipoItemExpor" => 1,
            "recintoFiscal" => $recintoFiscal,
            "regimen" => "EX-1.1000.000"
        ];

      
        if ($tipoDoc == '11') { //PARA FACTURA  DE EXPORTACION
            $emisor["tipoItemExpor"] = 1;
            $emisor["recintoFiscal"] = $recintoFiscal;
            $emisor["regimen"] = "EX-1.1000.000";
        }
        return $emisor;
    }

   
}
