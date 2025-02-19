<?php

namespace App\Help\DTEIdentificacion;

use App\Help\Generator;
use Illuminate\Support\Facades\Crypt;
use App\Models\MH\MHActividadEconomica;
use App\Help\Help;

class Identificacion
{

    public static function identidadContingencia( $version = 3){
        $empresa = Help::getEmpresa();
        $fechaHora = new \DateTime();
        $fecha = $fechaHora->format('Y-m-d');
        $hora = $fechaHora->format('H:i:s');

        $identificacion = [
            "version"=> $version,
            "ambiente"=>$empresa->ambiente,
            "codigoGeneracion" => Generator::generateCodeGeneration(),
            "fTransmision"=>$fecha,
            "hTransmision"=>$hora,
        ];
        return $identificacion;
    }

    public static function identidad($tipoDoc, $version = 1, $contingencia = null)
    {
        $empresa = Help::getEmpresa();
        $fechaHora = new \DateTime();

        $fecha = $fechaHora->format('Y-m-d');
        $hora = $fechaHora->format('H:i:s');
        $numeroControl = Generator::generateNumControl($tipoDoc);

        $identificacion =  [
            "version" => $version,
            "ambiente" => $empresa->ambiente,
            "tipoDte" => $tipoDoc,
            "numeroControl" =>  $numeroControl,
            "codigoGeneracion" => Generator::generateCodeGeneration(),
            "tipoOperacion" => 1,
            "tipoModelo" => 1,

            "fecEmi" => $fecha,
            "horEmi" => $hora,
            "tipoMoneda" => "USD"
        ];

        //^ CCF 03 | CD 15 | CL 08 | CR 07 | DCL 09 | FC 01 | FEX 11 | FSE 14 | NC 05 | ND 06 | NR 04
        $grupo1 = ["03", "07", "01", "11", "14", "05", "06"];

        if (in_array($tipoDoc, $grupo1)) {
            $identificacion["tipoContingencia"] = isset($contingencia["tipoContingencia"]) ? $contingencia["tipoContingencia"] : null;
        }

        $grupo2 = ["09", "08", "04"];
        if ($tipoDoc == "11")
            $identificacion['motivoContigencia'] =  isset($contingencia["motivoContigencia"]) ? $contingencia["motivoContigencia"] : null;
        elseif (!in_array($tipoDoc, $grupo2))
            $identificacion['motivoContin'] = isset($contingencia["motivoContin"]) ? $contingencia["motivoContin"] : null;


            if($tipoDoc=="04"){
                $identificacion['motivoContin'] = isset($contingencia["motivoContin"]) ? $contingencia["motivoContin"] : null;
                $identificacion["tipoContingencia"] = isset($contingencia["tipoContingencia"]) ? $contingencia["tipoContingencia"] : null;
            }
        return $identificacion;
    }


    public static function emisorContingencia($responsable, $dui, $establecimientoTipo="01", $codigoEstablecimiento = null, 
    $codPuntoVenta = null){
        $empresa = Help::getEmpresa();
        $nit = Crypt::decryptString($empresa->nit);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $telefono = Crypt::decryptString($empresa->telefono);
        $correo = Crypt::decryptString($empresa->correo_electronico);

        $emisor = [
            "nit" => $nit,
            "nombre" => $nombreEmpresa,
            "nombreResponsable"=> $responsable,
            "tipoDocResponsable"=> "13",
            "numeroDocResponsable"=> $dui,
            "tipoEstablecimiento"=> $establecimientoTipo,
            "codEstableMH"=> $codigoEstablecimiento,
            "codPuntoVenta"=> $codPuntoVenta,
            "telefono" => $telefono,
            "correo" => $correo,
        ];
        return $emisor;
    }

    public static function emisor($tipoDoc, $tipoEstablecimiento = null, $puntoDeVentaCodigo = null, $recintoFiscal = null, $regimen = null, $tipoItem = 2)
    {
        $empresa = Help::getEmpresa();
        $nit = Crypt::decryptString($empresa->nit);
        $nrc = Crypt::decryptString($empresa->nrc);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $telefono = Crypt::decryptString($empresa->telefono);
        $correo = Crypt::decryptString($empresa->correo_electronico);

        $actividad = MHActividadEconomica::where('codigo', $empresa->codigo_actividad)->first();

        $emisor = [
            "nit" => $nit,
            "nrc" =>  $nrc,
            "nombre" => $nombreEmpresa,
            "codActividad" => $empresa->codigo_actividad,
            "descActividad" => $actividad->valor,
            "direccion" => [
                "departamento" => $empresa->departamento,
                "municipio" => $empresa->municipio,
                "complemento" => $empresa->direccion
            ],
            "telefono" => $telefono,
            "correo" => $correo,
        ];

        if ($tipoDoc != "14") {
            $emisor["tipoEstablecimiento"] = $tipoEstablecimiento ?? '02';
            $emisor["nombreComercial"] = $empresa->nombre_comercial;
        }

        if ($tipoDoc == '11') { //PARA FACTURA  DE EXPORTACION
            $emisor["tipoItemExpor"] = $tipoItem ?? null;
            $emisor["recintoFiscal"] =  $recintoFiscal ?? null;
            $emisor["regimen"] =  $regimen ?? null;
        }

        $excepciones1 = ["05", "07", "06", "09"];
        if (!in_array($tipoDoc, $excepciones1)) { //PARA FACTURA DIFERENTE DE EXPORTACION
            $emisor["codEstableMH"] = $empresa->codigo_establecimiento;
            $emisor["codEstable"] =  null;
            $emisor["codPuntoVenta"] =  null;
            $emisor["codPuntoVentaMH"] =  $puntoDeVentaCodigo ?? $empresa->codigo_establecimiento;
        }

        $grupo1 = ["07", "09"];
        if (in_array($tipoDoc, $grupo1)) {

            $emisor["codigoMH"] = $empresa->codigo_establecimiento;
            $emisor["codigo"] =  null;
            $emisor["puntoVenta"] =  null;
            $emisor["puntoVentaMH"] =  $puntoDeVentaCodigo ?? $empresa->codigo_establecimiento;
        }

        return $emisor;
    }
}
