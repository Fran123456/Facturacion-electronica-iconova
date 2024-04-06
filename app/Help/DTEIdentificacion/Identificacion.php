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
    {
        $empresa = Help::getEmpresa();
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
           
            "fecEmi" => $fecha_actual->format('Y-m-d'),
            "horEmi" => $fecha_actual->format('H:i:s'),
            "tipoMoneda" => "USD"
        ];

        if($tipoDoc=="01") //factura
        {
            $identificacion['motivoContin']=null;
        }else{
            $identificacion['motivoContigencia']=  null;
        }
        return $identificacion;
    }



    public static function receptor($clienteR)
    {

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

        $actividadCliente = MHActividadEconomica::where('codigo', $clienteR['descActividad'])->first();
        if ($actividadCliente == null) {
            $actividadCliente = MHActividadEconomica::where('codigo', '10005')->first();
        }

        $dui = null;
        $tipoDocumentoCliente = MHTipoDocumento::where('codigo', $clienteR['tipoDocumento'])->first();
        if ($tipoDocumentoCliente == null) {
            return array("error" => true, "comentario" => "El tipo de documento no coinciden en la base de datos");
        } else {
            if ($tipoDocumentoCliente->valor == 'DUI') {
                $dui = $clienteR['dui'] ?? null;
                if (!isset($clienteR['dui'])) {
                    return array("error" => true, "comentario" => "El campo dui es requerido ya que el tipo de documento seleccionado para el cliente ha sido DUI");
                }
            }
        }

        $paisCliente = MHPais::where('codigo', $clienteR['pais'])->first();
        if ($paisCliente == null) {
            $paisCliente = MHPais::where('codigo', '9999')->first();
        }



        if ($cliente == null) {

            $cliente = Cliente::create([
                'nit' =>  $clienteR['numDocumento'],
                'tipo_documento' =>  $clienteR['tipoDocumento'],
                'nrc' =>  $clienteR['nrc'] ?? null,
                'dui' =>  $dui,
                'nombre' => $clienteR['nombre'],
                'codigo_actividad' => $actividadCliente->codigo,
                'descripcion_actividad' => $actividadCliente->valor,
                'nombre_comercial' => $clienteR['nombreComercial'] ?? $clienteR['nombre'],
                'departamento' => $clienteR['departamento'] ?? null,
                'municipio' => $clienteR['municipio'] ?? null,
                'complemento' => $clienteR['direccion'] ?? null,
                'telefono' => $clienteR['telefono'] ?? null,
                'correo' => $clienteR['correo'] ?? null,
                'estado' => 1
            ]);
        } else {
            $cliente = Cliente::where('nit', $clienteR['numDocumento'])->update([
                'nit' =>  $clienteR['numDocumento'],
                'tipo_documento' =>  $clienteR['tipoDocumento'],
                'nrc' =>  $clienteR['nrc'] ?? null,
                'dui' => $dui,
                'nombre' => $clienteR['nombre'],
                'codigo_actividad' => $actividadCliente->codigo,
                'descripcion_actividad' => $actividadCliente->valor,
                'nombre_comercial' => $clienteR['nombreComercial'] ?? $clienteR['nombre'],
                'departamento' => $clienteR['departamento'] ?? null,
                'municipio' => $clienteR['municipio'] ?? null,
                'complemento' => $clienteR['direccion'] ?? null,
                'telefono' => $clienteR['telefono'] ?? null,
                'correo' => $clienteR['correo'] ?? null,
                'estado' => 1
            ]);
            $cliente = Cliente::where('nit', $clienteR['numDocumento'])->first();
        }


        $clienteF =  [
            "nombre" => $cliente['nombre'],
            "tipoDocumento" =>  $tipoDocumentoCliente->codigo,
            "numDocumento" => $clienteR['numDocumento'],
            "codPais" => $cliente['pais'] ?? '9999',
            "nombrePais" => $paisCliente->valor,
            "complemento" => $clienteR['direccion'],
            "tipoPersona" => $clienteR['tipoPersona'],
            "descActividad" => $actividadCliente->valor,
            "nombreComercial" => $cliente['nombreComercial'] ?? $cliente['nombre'],
            "telefono" => $cliente['telefono'],
            "correo" => $cliente['correo'],
        ];
        return $clienteF;
    }

    public static function receptorCCF($receptor)
    {

        $nit = $receptor['nit'];
        $cliente = Cliente::where('nit', $nit)->first();

        $nrc = $receptor['nrc'];
        $nombre = $receptor['nombre'];
        $codigoActividad = $receptor['codActividad'];
        $descripcionActividad = $receptor['descActividad'];
        $nombreComercial = $receptor['nombreComercial'];
        $departamento = $receptor['direccion']['departamento'];
        $municipio = $receptor['direccion']['municipio'];
        $complemento = isset($receptor['direccion']['complemento']) ? $receptor['direccion']['complemento'] : 'Sin complemento';
        $telefono = $receptor['telefono'];
        $correo = $receptor['correo'];

        if ($cliente == null) {

            $cliente = Cliente::create([
                'tipo_documento' => '03',
                'nit' => $nit,
                'nrc' => $nrc,
                'dui' => Generator::generateCodeGeneration(),
                'nombre' => $nombre,
                'codigo_actividad' => $codigoActividad,
                'descripcion_actividad' => $descripcionActividad,
                'nombre_comercial' => $nombreComercial,
                'departamento' => $departamento,
                'municipio' => $municipio,
                'complemento' => $complemento,
                'telefono' => $telefono,
                'correo' => $correo,
            ]);

            $cliente->save();

            return $receptor;
        } else {

            Cliente::where('id', $cliente->id)->update([
                'tipo_documento' => '03',
                'nit' => $nit,
                'nrc' => $nrc,
                'dui' => Generator::generateCodeGeneration(),
                'nombre' => $nombre,
                'codigo_actividad' => $codigoActividad,
                'descripcion_actividad' => $descripcionActividad,
                'nombre_comercial' => $nombreComercial,
                'departamento' => $departamento,
                'municipio' => $municipio,
                'complemento' => $complemento,
                'telefono' => $telefono,
                'correo' => $correo,
            ]);
        }

        $newReceptor = [];

        $newReceptor['nit'] = $cliente->nit;
        $newReceptor['nrc'] = $cliente->nrc;
        $newReceptor['nombre'] = $cliente->nombre;
        $newReceptor['codActividad'] = $cliente->codigo_actividad;
        $newReceptor['descActividad'] = $cliente->descripcion_actividad;
        $newReceptor['nombreComercial'] = $cliente->nombre_comercial;
        $newReceptor['direccion']['departamento'] = $cliente->departamento;
        $newReceptor['direccion']['municipio'] = $cliente->municipio;
        $newReceptor['direccion']['complemento'] = $cliente->complemento;
        $newReceptor['telefono'] = $cliente->telefono;
        $newReceptor['correo'] = $cliente->correo;

        return $newReceptor;
    }

    public static function receptorFactura($receptor)
    {
        $cliente = Cliente::where('nit', $receptor['numDocumento'])->first();

        $descripcionActividad = $receptor['descActividad'];
        $numDocumento = $receptor['numDocumento'];
        $codigoActividad = $receptor['codActividad'];
        $correo = $receptor['correo'];
        $departamento = $receptor['direccion']['departamento'];
        $municipio = $receptor['direccion']['municipio'];
        $complemento = isset($receptor['direccion']['complemento']) ? $receptor['direccion']['complemento'] : 'Sin complemento';
        $telefono = $receptor['telefono'];
        $nombre = $receptor['nombre'];
        $nrc = $receptor['nrc']??null;

        if ($cliente == null) {

            $cliente = Cliente::create([
                'tipo_documento' => '13',
                'nit' => (string)$numDocumento,
                'nrc' => (string)$nrc ?? null,
                'dui' => (string)$numDocumento,
                'nombre' => (string)$nombre,
                'codigo_actividad' => (string)$codigoActividad,
                'descripcion_actividad' => (string)$descripcionActividad,
                'nombre_comercial' => (string)$receptor['nombreComercial'] ?? (string)$receptor['nombre'],
                'departamento' => (string)$departamento,
                'municipio' => (string)$municipio,
                'complemento' => (string)$complemento,
                'telefono' => (string)$telefono,
                'correo' => (string)$correo,
            ]);

            $cliente->save();

            return $receptor;
        } else {

            Cliente::where('id', $cliente->id)->update([
                'tipo_documento' => '13',
                'nit' => (string)$numDocumento,
                'nrc' => (string)$nrc ?? null,
                'dui' => (string)$numDocumento,
                'nombre' => (string)$nombre,
                'codigo_actividad' => (string)$codigoActividad,
                'descripcion_actividad' => (string)$descripcionActividad,
                'nombre_comercial' => (string)$receptor['nombreComercial'] ?? $receptor['nombre'],
                'departamento' => (string)$departamento,
                'municipio' => (string)$municipio,
                'complemento' => (string)$complemento,
                'telefono' => (string)$telefono,
                'correo' => (string)$correo,
            ]);
        }

        $newReceptor = [];

        $newReceptor['descActividad'] = $cliente->descripcion_actividad;
        $newReceptor['tipoDocumento'] = $cliente->tipo_documento;
        $newReceptor['numDocumento'] = $cliente->dui;
        $newReceptor['codActividad'] = $cliente->codigo_actividad;
        $newReceptor['correo'] = $cliente->correo;
        $newReceptor['direccion']['departamento'] = $cliente->departamento;
        $newReceptor['direccion']['municipio'] = $cliente->municipio;
        $newReceptor['direccion']['complemento'] = $cliente->complemento;
        $newReceptor['telefono'] = $cliente->telefono;
        $newReceptor['nombre'] = $cliente->nombre;
        $newReceptor['nrc'] = $cliente->nrc==""?null:$cliente->nrc;

        return $newReceptor;
    }


    public static function emisor($tipoDoc, $tipoEstablecimiento, $puntoDeVentaCodigo, $recintoFiscal = null, $regimen = null)
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
            "codEstableMH" => $empresa->codigo_establecimiento,
            "codEstable" => null,
            "codPuntoVenta" => null,
            "codPuntoVentaMH" => $puntoDeVentaCodigo ?? $empresa->codigo_establecimiento,
        ];


        if ($tipoDoc == '11') { //PARA FACTURA  DE EXPORTACION
            $emisor["tipoItemExpor"] = 1;
            $emisor["recintoFiscal"] =  $recintoFiscal ?? $recintoFiscal;
            $emisor["regimen"] =  $regimen ?? "EX-1.1000.000";
        }
        return $emisor;
    }
}
