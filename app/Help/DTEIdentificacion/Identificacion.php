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

    public static function identidad($tipoDoc)
    {   $empresa = Help::getEmpresa();
        $fecha_actual = new \DateTime();
        $identificacion =  [
            "version" => 1,
            "ambiente" => $empresa->ambiente,
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



    public static function receptor($clienteR){

       /*RECEPTOR A CONSTRUIR
        "receptor": {
        "nombre": "GUILLERMO ANTONIO DURAN MORALES",
        "codPais": "9300",
        "nombrePais": "EL SALVADOR",
        "complemento": "CTON CARA SUCIA 34",
        "tipoDocumento": "13",
        "numDocumento": "33883797-8",
        "tipoPersona": 1,
        "descActividad": "Programación Informática",
        "nombreComercial": "SYSMMOTECH",
        "telefono": "24202677",
        "correo": "SYSMMOTECH@GMAIL.COM"
        },
        */

        $cliente = Cliente::where('nit', $clienteR['numDocumento'])->first();

        $actividadCliente = MHActividadEconomica::where('codigo',$clienteR['descActividad'])->first();
        if($actividadCliente==null){
            $actividadCliente = MHActividadEconomica::where('codigo','10005')->first();
        }

        $dui =null;
        $tipoDocumentoCliente = MHTipoDocumento::where('codigo',$clienteR['tipoDocumento'])->first();
        if($tipoDocumentoCliente==null){
           return array("error"=> true, "comentario"=> "El tipo de documento no coinciden en la base de datos");
        }else{
            if($tipoDocumentoCliente->valor =='DUI'){
                $dui=$clienteR['dui']??null;
                if(!isset($clienteR['dui'])){
                    return array("error"=> true, "comentario"=> "El campo dui es requerido ya que el tipo de documento seleccionado para el cliente ha sido DUI");
                }
            }
        }

        $paisCliente = MHPais::where('codigo',$clienteR['pais'])->first();
        if($paisCliente==null){
            $paisCliente = MHPais::where('codigo','9999')->first();
        }



        if($cliente==null){

            $cliente= Cliente::create([
                'nit'=>  $clienteR['numDocumento'],
                'tipo_documento'=>  $clienteR['tipoDocumento'],
                'nrc'=>  $clienteR['nrc']??null,
                'dui'=>  $dui,
                'nombre'=> $clienteR['nombre'],
                'codigo_actividad'=> $actividadCliente->codigo,
                'descripcion_actividad'=> $actividadCliente->valor,
                'nombre_comercial'=> $clienteR['nombreComercial']??$clienteR['nombre'],
                'departamento'=> $clienteR['departamento']??null,
                'municipio'=> $clienteR['municipio']??null,
                'complemento'=> $clienteR['direccion']??null,
                'telefono'=> $clienteR['telefono']??null,
                'correo'=> $clienteR['correo']??null,
                'estado'=>1
            ]);
        }else{
            $cliente= Cliente::where('nit',$clienteR['numDocumento'])->update([
                'nit'=>  $clienteR['numDocumento'],
                'tipo_documento'=>  $clienteR['tipoDocumento'],
                'nrc'=>  $clienteR['nrc']??null,
                'dui'=> $dui,
                'nombre'=> $clienteR['nombre'],
                'codigo_actividad'=> $actividadCliente->codigo,
                'descripcion_actividad'=> $actividadCliente->valor,
                'nombre_comercial'=> $clienteR['nombreComercial']??$clienteR['nombre'],
                'departamento'=> $clienteR['departamento']??null,
                'municipio'=> $clienteR['municipio']??null,
                'complemento'=> $clienteR['direccion']??null,
                'telefono'=> $clienteR['telefono']??null,
                'correo'=> $clienteR['correo']??null,
                'estado'=>1
            ]);
            $cliente = Cliente::where('nit',$clienteR['numDocumento'])->first();
        }


        $clienteF =  [
            "nombre" => $cliente['nombre'],
            "tipoDocumento" =>  $tipoDocumentoCliente->codigo,
            "numDocumento" => $clienteR['numDocumento'],
            "codPais" => $cliente['pais']??'9999',
            "nombrePais" => $paisCliente->valor,
            "complemento" => $clienteR['direccion'],
            "tipoPersona"=> $clienteR['tipoPersona'],
            "descActividad"=> $actividadCliente->valor,
            "nombreComercial"=>$cliente['nombreComercial']??$cliente['nombre'],
            "telefono"=> $cliente['telefono'],
            "correo"=> $cliente['correo'],
         ] ;
        return $clienteF;
    }


    public static function emisor($tipoDoc,$tipoEstablecimiento, $puntoDeVentaCodigo, $recintoFiscal = null, $regimen=null)
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
            "tipoEstablecimiento" => $tipoEstablecimiento??'02',
            "direccion" => [
                "departamento" => $empresa->departamento,
                "municipio" => $empresa->municipio,
                "complemento" => $empresa->direccion
            ],
            "telefono" => $telefono,
            "correo" => $correo,
            "codEstableMH" => $empresa->codigo_establecimiento,
            "codEstable"=> null,
            "codPuntoVenta"=>null,
            "codPuntoVentaMH" => $puntoDeVentaCodigo??$empresa->codigo_establecimiento,
            "tipoItemExpor" => 1,
            "recintoFiscal" => $recintoFiscal??'01',
            "regimen" => $regimen??'EX-1.1000.000'


        ];


        if ($tipoDoc == '11') { //PARA FACTURA  DE EXPORTACION
            $emisor["tipoItemExpor"] = 1;
            $emisor["recintoFiscal"] = $recintoFiscal;
            $emisor["regimen"] = "EX-1.1000.000";
        }
        return $emisor;
    }


}
