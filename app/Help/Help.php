<?php

namespace App\help;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Empresa;
use App\Models\MH\MHFormaPago;
use App\Models\MH\MHTributo;
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

        if (!$forma->id) {
            return $forma->valor;
        }

        return null;
    }

    public static function getCliente($receptor)
    {

        $nit = $receptor['nit'];
        $cliente = Cliente::where('nit', $nit)->first();

        if ($cliente == null) {
            $nrc = $receptor['nrc'];
            $nombre = $receptor['nombre'];
            $codigoActividad = $receptor['codActividad'];
            $descripcionActividad = $receptor['descActividad'];
            $nombreComercial = $receptor['nombreComercial'];
            $departamento = $receptor['direccion']['departamento'];
            $municipio = $receptor['direccion']['municipio'];
            $complemento = isset($receptor['direccion']['complemento']) ? $receptor['direccion']['complemento'] : ' ';
            $telefono = $receptor['telefono'];
            $correo = $receptor['correo'];

            $cliente = Cliente::create([
                'tipo_documento' => '03',
                'nit' => $nit,
                'nrc' => $nrc,
                'dui' => Generator::generateCodeGeneration(),
                'nombre' => $nombre,
                'codigo_activad' => $codigoActividad,
                'descripcion_activad' => $descripcionActividad,
                'nombre_comercial' => $nombreComercial,
                'departamento' => $departamento,
                'municipio' => $municipio,
                'complemento' => $complemento,
                'telefono' => $telefono,
                'correo' => $correo,
            ]);

            $cliente->save();

            return $receptor;
        }

        $newReceptor = [];

        $receptor['nit'] = $cliente->nit;
        $receptor['nrc'] = $cliente->nrc;
        $receptor['nombre'] = $cliente->nrc;
        $receptor['codActividad'] = $cliente->nrc;
        $receptor['descActividad'] = $cliente->nrc;
        $receptor['nombreComercial'] = $cliente->nrc;
        $receptor['direccion']['departamento'] = $cliente->nrc;
        $receptor['direccion']['municipio'] = $cliente->nrc;
        $receptor['direccion']['complemento'] = $cliente->nrc;
        $receptor['telefono'] = $cliente->nrc;
        $receptor['correo'] = $cliente->nrc;
    }
}
