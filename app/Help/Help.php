<?php

namespace App\help;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Empresa;
use App\Models\MH\MHFormaPago;
use App\Models\MH\MHTributo;
use Exception;
use Illuminate\Support\Facades\Auth;

class Help
{

    public static function mhProduccion()
    {
        return Config::where('key_conf', 'AMBIENTE_API_MH_PRODUCCION')->first()->valor;
    }

    public static function urlFirmador()
    {
        return Config::where('key_conf', "FIRMADOR_URL_BASE")->first()?->valor;
    }

    public static function mhDev()
    {
        return Config::where('key_conf', "URL_MH_DTES_TEST")->first()?->valor;
    }

    public static function mhProd()
    {
        return Config::where('key_conf', "URL_MH_DTES")->first()?->valor;
    }

    public static  function mhUrl()
    {
        if (self::mhProduccion()) {
            return self::mhProd();
        }
        return self::mhDev();
    }

    public static function getEmpresa()
    {
        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);
        return $empresa;
    }
    
    public static function getUsuario(){
        return Auth::user();
    }

    public static function getEmisorDefault()
    {
        $emisor = [];

        $emisor['nit'] = '06141802161055';
        $emisor['nrc'] = '2496424';
        $emisor['nombre'] = 'XPERTIS, S.A de C.V.';
        $emisor['codActividad'] = '70200';
        $emisor['descActividad'] = 'Actividades de consultoría en gestión empresarial';
        $emisor['nombreComercial'] = 'Iconova Consulting Group';
        $emisor['tipoEstablecimiento'] = '20';
        $emisor['direccion']['departamento'] = '06';
        $emisor['direccion']['municipio'] = '14';
        $emisor['direccion']['complemento'] = 'Calle Los Abetos y Calle Los Bambúes #37, Col. San Francisco';
        $emisor['telefono'] = '617542485';
        $emisor['correo'] = 'contacto@iconovasv.com';
        $emisor['codEstableMH'] = 'M001';
        $emisor['codEstable'] = null;
        $emisor['codPuntoVentaMH'] = 'M001';
        $emisor['codPuntoVenta'] = null;

        return $emisor;
    }

    public static function getTributo($codigo)
    {
        $tributo = MHTributo::where('codigo', $codigo)->first();

        if ($tributo->id)
            return $tributo->valor;

        return 'Sin descripcion';
    }

    public static function getTax($codigo, $subtotal, $totalGalones = 0)
    {

        $tributo = MHTributo::where('codigo', $codigo)->first();

        if (!$tributo->id)
            return 0;

        $retorno = 0;

        $porcentaje = $tributo->porcentaje;

        switch ($tributo->codigo) {
            case '20':
            case 'C3':
            case '59':
                $retorno = $subtotal * $porcentaje;
                break;
        }

        return $retorno;
    }

    public static function numberToString($numero)
    {
        $conversion = array(
            0 => 'cero',
            1 => 'uno',
            2 => 'dos',
            3 => 'tres',
            4 => 'cuatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'siete',
            8 => 'ocho',
            9 => 'nueve'
        );

        $decenas = array(
            2 => 'veinte',
            3 => 'treinta',
            4 => 'cuarenta',
            5 => 'cincuenta',
            6 => 'sesenta',
            7 => 'setenta',
            8 => 'ochenta',
            9 => 'noventa'
        );

        $centenas = array(
            1 => 'ciento',
            2 => 'doscientos',
            3 => 'trescientos',
            4 => 'cuatrocientos',
            5 => 'quinientos',
            6 => 'seiscientos',
            7 => 'setecientos',
            8 => 'ochocientos',
            9 => 'novecientos'
        );

        if ($numero < 10) {
            return $conversion[$numero];
        } elseif ($numero < 20) {
            $conversion_especial = array(
                10 => 'diez',
                11 => 'once',
                12 => 'doce',
                13 => 'trece',
                14 => 'catorce',
                15 => 'quince',
                16 => 'dieciséis',
                17 => 'diecisiete',
                18 => 'dieciocho',
                19 => 'diecinueve'
            );
            return $conversion_especial[$numero];
        } elseif ($numero < 100) {
            $decena = floor($numero / 10);
            $unidad = $numero % 10;

            $texto = $decenas[$decena];

            if ($unidad == 0) {
                return $texto;
            } else {
                return $texto . ' y ' . $conversion[$unidad];
            }
        } elseif ($numero < 1000) {
            $centena = floor($numero / 100);
            $resto = $numero % 100;

            if ($resto == 0) {
                return $centenas[$centena];
            } else {
                return $centenas[$centena] . ' ' . Help::numberToString($resto);
            }
        } elseif ($numero < 1000000) {
            $millar = floor($numero / 1000);
            $resto = $numero % 1000;

            if ($resto == 0) {
                return Help::numberToString($millar) . ' mil';
            } else {
                return Help::numberToString($millar) . ' mil ' . Help::numberToString($resto);
            }
        }
    }

    public static function getPayWay($way)
    {
        $forma = MHFormaPago::where('codigo', $way)->first();

        if ($forma!=null) {
            return $forma->valor;
        }

        return null;
    }

    public static function getClienteId($numDocumento)
    {

        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();

        if ($cliente == null)
            throw new Exception("No existe ningun registro para cliente con nit/dui $numDocumento");

        // return $cliente->id;
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }


    public static function ValidarCliente($numDocumento, $clienteF)
    {

        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();

        if($cliente ==null){
            $cliente = Cliente::create([
                'nit'=> $clienteF['nit']??null,
                'nrc'=> $clienteF['nrc']??null,
                'dui'=> $clienteF['dui']??null,
                'nombre'=> $clienteF['nombre'],
                'codigo_actividad'=> $clienteF['codActividad'],
                'descripcion_actividad'=> $clienteF['descActividad'],
                'nombre_comercial'=> $clienteF['nombreComercial'],
                'departamento'=>  $clienteF['direccion']['departamento'],
                'municipio'=> $clienteF['direccion']['municipio'],
                'complemento'=> $clienteF['direccion']['complemento'],
                'telefono'=> $clienteF['telefono'],
                'correo'=> $clienteF['correo'],
                'estado'=> 1,
            ]);
        }
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }


    public static function ValidarClienteByEmail($numDocumento,$correo, $clienteF)
    {
        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();
        if($cliente == null){
            $cliente = Cliente::where('correo', $correo)->first();
        }
        
        if($cliente ==null){
            $cliente = Cliente::create([
                'nit'=> $clienteF['nit']??null,
                'nrc'=> $clienteF['nrc']??null,
                'dui'=> $clienteF['dui']??null,
                'nombre'=> $clienteF['nombre'],
                'codigo_actividad'=> $clienteF['codActividad'],
                'descripcion_actividad'=> $clienteF['descActividad'],
                'nombre_comercial'=> $clienteF['nombreComercial'],
                'departamento'=>  $clienteF['direccion']['departamento'],
                'municipio'=> $clienteF['direccion']['municipio'],
                'complemento'=> $clienteF['direccion']['complemento'],
                'telefono'=> $clienteF['telefono'],
                'correo'=> $clienteF['correo']??null,
                'estado'=> 1,
            ]);
        }
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }

}
