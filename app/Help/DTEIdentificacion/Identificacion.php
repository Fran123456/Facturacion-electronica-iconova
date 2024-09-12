<?php

namespace App\Help\DTEIdentificacion;

use App\Models\Config;
use App\Help\Generator;
use Illuminate\Support\Facades\Crypt;
use App\Models\MH\MHActividadEconomica;
use App\Models\MH\MHTipoDocumento;
use App\Models\MH\MHPais;

use App\Help\Help;
use App\Models\Cliente;

class Identificacion
{

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

        // CCF 03 | CD 15 | CL 08 | CR 07 | DCL 09 | FC 01 | FEX 11 | FSE 14 | NC 05 | NC 06 | NR 04

        $grupo1 = ["03", "07", "01", "11", "14", "05", "06", "04"];

        if (in_array($tipoDoc, $grupo1)) {
            $identificacion["tipoContingencia"] = isset($contingencia["tipoContingencia"]) ? $contingencia["tipoContingencia"] : null;
        }

        // $grupo2 = ["03", "07", "01", "14", "05", "06", "04"];
        // if(in_array($tipoDoc, $grupo2))
        // else


        if ( $tipoDoc == "11" )
            $identificacion['motivoContigencia'] =  isset($contingencia["motivoContigencia"]) ? $contingencia["motivoContigencia"] : null;
        else
            $identificacion['motivoContin'] = isset($contingencia["motivoContin"]) ? $contingencia["motivoContin"] : null;

        return $identificacion;
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
            "nombreComercial" => $empresa->nombre_comercial,
            "tipoEstablecimiento" => $tipoEstablecimiento ?? '02',
            "direccion" => [
                "departamento" => $empresa->departamento,
                "municipio" => $empresa->municipio,
                "complemento" => $empresa->direccion
            ],
            "telefono" => $telefono,
            "correo" => $correo,
        ];


        if ($tipoDoc == '11') { //PARA FACTURA  DE EXPORTACION
            $emisor["tipoItemExpor"] = $tipoItem ?? null;
            $emisor["recintoFiscal"] =  $recintoFiscal ?? null;
            $emisor["regimen"] =  $regimen ?? null;
        }

        if ($tipoDoc !== '05') { //PARA FACTURA DIFERENTE DE EXPORTACION
            $emisor["codEstableMH"] = $empresa->codigo_establecimiento;
            $emisor["codEstable"] =  null;
            $emisor["codPuntoVenta"] =  null;
            $emisor["codPuntoVentaMH"] =  $puntoDeVentaCodigo ?? $empresa->codigo_establecimiento;
        }

        return $emisor;
    }
}
