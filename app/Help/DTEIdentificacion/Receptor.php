<?php

namespace App\Help\DTEIdentificacion;

use App\Models\Cliente;
use App\Models\MH\MHActividadEconomica;
use App\Models\MH\MHPais;
use Database\Seeders\MHCodigoActividadEconomica;

class Receptor
{

    public static function generar($receptorDte, $tipoDte)
    {

        // @ TIPO DE DTE 01 FACTURA PUEDE NO LLEVAR RECEPTOR
        if ( $tipoDte == "01" && $receptorDte == null )
            return [false, null];

        $nit = $receptorDte['nit']??null;
        $cliente = Cliente::where('nit', $nit)->first();

        $dui = $receptorDte['dui']??null;
        if($cliente == null){
            $nit = $receptorDte['dui']??null;
            $cliente = Cliente::where('dui', $dui)->first();
        }

        $correo = $receptorDte['correo'] ?? null;
        if($cliente == null){
            $nit = $receptorDte['correo']??null;
            $cliente = Cliente::where('correo', $dui)->first();
        }
      
        // SI NO EXISTE USUARIO CON EL NIT INGRESADO, SE CREA EL NUEVO USUARIO
        $code = null;
        if ($cliente == null) {
      

            // SE VALIDA SI FALTA ALGUN VALOR REQUERIDO
            [$faltan, $faltantes] = self::createCliente($receptorDte, $tipoDte);

            if ($faltan)
                return [$faltan, $faltantes];

            $code = MHActividadEconomica::where('codigo', $receptorDte['codActividad'])->first();
            

            $cliente = Cliente::create([
                'tipo_documento' => $tipoDte,
                'nit' => $nit,
                'nrc' => $receptorDte['nrc'],
                'dui' => $receptorDte['dui'],
                'nombre' => $receptorDte['nombre'],
                'codigo_actividad' => $receptorDte['codActividad'],
                'descripcion_actividad' => $code->valor,
                'nombre_comercial' => $receptorDte['nombreComercial'],
                'departamento' => $receptorDte['direccion']['departamento'],
                'municipio' => $receptorDte['direccion']['municipio'],
                'complemento' => isset($receptorDte['direccion']['complemento']) ? $receptorDte['direccion']['complemento'] : 'Sin complemento',
                'telefono' =>  $receptorDte['telefono'],
                'correo' => $correo,
            ]);
        } else {
            // SE VALIDA SI HAY INFORMACION A ACTUALIZAR
            $code = MHActividadEconomica::where('codigo', $receptorDte['codActividad'])->first();
            $receptorDte['descripcion_actividad']= $code?->valor;
            if(isset($receptorDte['nrc'])){
                 $receptorDte['nrc']=  str_replace('-', '', $receptorDte['nrc']);
            }

            $update = self::updateCliente($receptorDte);
           
            $cliente->update($update);
            
        }
        $cliente = Cliente::find($cliente?->id);
        // SE CREAN CAMPOS GENERALES PARA TODOS LOS DTE
        $receptor = [
            "nombre" => $cliente->nombre,
            "descActividad" =>$cliente->descripcion_actividad,
            "telefono" => $cliente->telefono,
            "correo" => $cliente->correo,
        ];

        if ( $tipoDte == "14" ){
            $receptor["codActividad"] = $cliente->codigo_actividad;
        }

        // CCF 03 | CD 15 | CL 08 | CR 07 | DCL 09 | FC 01 | FEX 11 | FSE 14 | NC 05 | NC 06 | NR 04

        // DTE QUE NO LLEVA EL CAMPO "NOMBRE COMERCIAL"
        $excepciones = ["01", "14"];
            if ( !in_array($tipoDte, $excepciones ))
                $receptor["nombreComercial"] = $cliente->nombre_comercial;

        // PARA DTE DIFERENTES A FACTURACION EXPORTACION
        if ( $tipoDte != "11")
            $receptor["direccion"] = [
                "departamento" => $cliente->departamento,
                "municipio" => $cliente->municipio,
                "complemento" => $cliente->complemento == null ? 'Sin complemento' : $cliente->complemento,
            ];

        // SE COMPLETA LOS CAMPOS SEGUN TIPO DTE
        $receptor = self::compretarReceptor($receptor, $cliente, $receptorDte, $tipoDte);

        return [false, $receptor];
    }

    private static function updateCliente($receptor)
    {
        $campos = [
            'tipo_documento' => 'tipo_documento',
           // 'nit' => 'nit',
           // 'nrc' => 'nrc',
           // 'dui' => 'dui',
            'nombre' => 'nombre',
            'codigo_actividad' => 'codActividad',
            'descripcion_actividad' => 'descripcion_actividad',
            'nombre_comercial' => 'nombreComercial',
            'telefono' => 'telefono',
            'correo' => 'correo',
            'nrc'=>'nrc'
        ];

        $camposDireccion = [
            'departamento',
            'municipio',
            'complemento',
        ];

        $cliente = [];

        // SE VERIFICA SI SE ACTUALIZARA INFORMACION EN LOS CAMPOS QUE NO SEAN DE DIRECCION
        foreach ($campos as $key => $campo) {
            if (isset($receptor[$campo])) {
                $cliente[$key] = $receptor[$campo];
            }
        }

        // SE VERIFICA SI SE ACTUALIZARA INFORMACION EN LOS CAMPOS DE DIRECCION
        foreach ($camposDireccion as $campo) {
            if (isset($receptor['direccion'][$campo])) {
                $cliente[$campo] = $receptor['direccion'][$campo];
            }
        }

        return $cliente;
    }

    private static function createCliente($receptor, $tipoDTE)
    {

        $excepciones = ["15", "14", "11",];

        $faltantes = [];

        $base = [
            "nit",
            "dui",
            "nombre",
            "descActividad",
            "nombreComercial",
            "telefono",
            "correo"
        ];

        $direccion = [
            "departamento",
            "municipio",
            "complemento"
        ];

        // Campos en comun para CCF, CL, NC,ND CR, DCL, FC, NR
        $grupo = [
            "nrc",
            "codActividad"
        ];

        foreach ($base as $item) {
            if (!isset($receptor[$item])) {
                $long = count($faltantes) + 1;
                $faltantes["campo" . $long] =  "campo { $item } es requerido";
            }
        }

        foreach ($direccion as $item) {
            if (!isset($receptor['direccion'][$item])) {
                $long = count($faltantes) + 1;
                $faltantes["campo" . $long] =  "campo { $item } en direccion es requerido";
            }
        }

        if (!in_array($tipoDTE, $excepciones)) {

            foreach ($grupo as $item) {
                if (!isset($receptor[$item])) {
                    $long = count($faltantes) + 1;
                    $faltantes["campo" . $long] =  "campo " . $item . " es requerido";
                }
            }
        }

        $faltan = false;

        // if (count($faltantes) > 0)
        if (!empty($faltantes))
            $faltan = true;

        return [$faltan, $faltantes];
    }

    public static function compretarReceptor($receptor, $cliente, $complemento, $tipoDTE)
    {
        //^ CCF 03 | CD 15 | CL 08 | CR 07 | DCL 09 | FC 01 | FEX 11 | FSE 14 | NC 05 | NC 06 | NR 04
        $grupo1 = ["03", "08", "07", "09", "05", "06", "04", "01"];
        $grupoNit = ["03", "08", "09", "05", "06"];
        // PARA DTES DE CCF CL CR DCL NC ND NR
        if (in_array($tipoDTE, $grupo1)) {

            $receptor["nrc"] = $cliente->nrc;
            $receptor["codActividad"] = $cliente->codigo_actividad;

            // Solo se agrega el nit si es necesario es dte CCF 03 | CL 08 | DCL 09 | NC 05 | NC 06
            if (in_array($tipoDTE, $grupoNit))
                $receptor["nit"] = $cliente->nit;
        }

        // PARA CAMPOS NUMDOCUMENTO, TIPODOCUMENTO
        $grupo2 = ["07", "01", "11", "04"];
        if (in_array($tipoDTE, $grupo2)) {
            $receptor["tipoDocumento"] = $complemento["tipoDocumento"];
            $receptor["numDocumento"] = ($complemento["tipoDocumento"] == "36")
                ? $cliente->nit
                : (($complemento["tipoDocumento"] == "13") ? $cliente->dui
                : $complemento["numDocumento"]);
        }
        
        if($tipoDTE == "01" || $tipoDTE == "04"){
            $receptor["numDocumento"] = $complemento["numDocumento"];
        }

        // Campos para DCL
        if ($tipoDTE == "09") {
            $receptor["tipoEstablecimiento"] = $complemento["tipoEstablecimiento"] ?? "01";
            $receptor["codigoMH"] = $complemento["codigoMH"] ?? null;
            $receptor["puntoVentaMH"] = $complemento["puntoVentaMH"] ?? null;
        }

        // Campos para FEX
        if ($tipoDTE == "11") {
            $pais = MHPais::where('codigo', $complemento["codPais"])->first();
            $receptor["codPais"] = $complemento["codPais"];
            $receptor["nombrePais"] = $pais->valor;
            $receptor["complemento"] = $complemento["complemento"];
            $receptor["tipoPersona"] = $complemento["tipoPersona"] ;
        }

       if ($tipoDTE == "04")
            $receptor["bienTitulo"] = $complemento["bienTitulo"];

        if ( $tipoDTE == "14" ) {
            $receptor["tipoDocumento"] = $complemento["tipoDocumento"];
            $receptor["numDocumento"] = $complemento["numDocumento"];
        }

        

        return $receptor;
    }
}
